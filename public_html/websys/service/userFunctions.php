<?php
class console
{
    static public function write($string)
    {
        print $string;
    }

    static public function writeLine($string, $timestamp = true)
    {
        print ($timestamp ? "[" . date("d-m-Y H:i:s") . "] " : "") . $string . "\r\n";
    }
}

/**
* Debug function. Returns or display var_dump of var.
*
* @param mixed $var
* @param bool $die
* @param bool $asString
* @return null | string (if $asString = true)
*/
function debugMe($var, $die = true, $asString = false) {
    if($asString) {
        ob_start();
        var_dump($var);
        $deb_content = ob_get_contents();
        ob_end_clean();
        return $deb_content;
    }
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    if($die) {
        die();
    }
}

/**
* DbSimple error handler
*
* @param string $message
* @param array $info
*/
function databaseErrorHandler($message, $info){
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>";
    print_r($info);
    echo "</pre>";
    exit();
}

/**
* DbSimple console error handler
*
* @param string $message
* @param array $info
*/
function databaseConsoleErrorHandler($message, $info){
    if (!error_reporting()) return;
    console::writeLine("SQL Error: {$message}");
    console::writeLine(print_r($info));
    exit;
}

/**
* Instance of DbSimple object connected to DB
*
* @return DbSimple_Generic
*/
function DbSimpleInstance($data = array())
{
    if(!count($data)) {
        $data = systemConfig::$db['default'];
    }
    fileLoader::load("/libraries/DbSimple/Generic");

    $db = DbSimple_Generic::connect("mysql://" . $data['user'] . ":" . $data['password'] . "@" . $data['host'] . "/" . $data['dbname']);
    if(!$db) {
        return false;
    }
    $db->query("SET NAMES `utf8`");
    $db->setErrorHandler('databaseConsoleErrorHandler');
    return $db;
}

/**
* Log me into database with comment and status_id
* Status IDs:
*            0 => Simple log
*            1 => Notice
*            2 => Alert, system can repair
*            3 => Warning, system can not repair
*            4 => Global exception, system halted
* By default system ID is setted to 0
*
* @param string $comment
* @param int $status_id
* @param array $data | array with some data which would be var_dumped to log :)
* @param integer $update_process the id of udpate process
*/
function logMe($comment, $status_id = 0, $data = array(), $update_process = 0) {

    if (!class_exists('systemToolkit')) {
        return; // not loaded (cache fix)
    }
    $toolkit = systemToolkit::getInstance();
    $centerLogMapper = $toolkit->getMapper('log', 'log');

    if(count($data)) {
        ob_start();
        $i = 1;
        foreach($data as $d) {
            var_dump($d);
            if($i < count($data)) {
                echo "<br />===<br />";
            }
            $i++;
        }
        $err_content = ob_get_contents();
        ob_end_clean();
        $comment .= "<br />{$err_content}";
    }

    $log = $centerLogMapper->create();
    $log->setTime(new SQLFunction('UNIX_TIMESTAMP'));
    $log->setModule($toolkit->getRequest()->getModule());
    $log->setAction($toolkit->getRequest()->getAction());
    $log->setComment($comment);
    $log->setStatus($status_id);
    if ($user = systemToolkit::getInstance()->getUser()) {
        $log->setUser($user);
    }
    if ($update_process) {
        $log->setProcessId($update_process);
    }
    $centerLogMapper->save($log);
}

/**
* Put message to NeoLOG
*
* @param string $changes
* @param array $data
*/
function neolog($changes, $data = array()) {
    $toolkit = systemToolkit::getInstance();
    $neologMapper = $toolkit->getMapper('neolog', 'message');
    $err_content = "";

    if(count($data)) {
        if(count($data) == 2) {
            ob_start();
            $i = 1;
            foreach($data as $d) {
                var_dump($d);
                if($i < count($data)) {
                    echo "\n\nVS.\n\n";
                }
                $i++;
            }
            $err_content = ob_get_contents();
            ob_end_clean();
        } else {
            ob_start();
            $i = 1;
            foreach($data as $d) {
                var_dump($d);
                if($i < count($data)) {
                    echo "\n===\n";
                }
                $i++;
            }
            $err_content = ob_get_contents();
            ob_end_clean();
        }
    }

    $err_content = str_replace("\n", "<br />", str_replace("\r", "", str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", str_replace(" ", "&nbsp;", $err_content))));

    $neolog = $neologMapper->create();
    $neolog->setTime(new SQLFunction('UNIX_TIMESTAMP'));
    $neolog->setModule($toolkit->getRequest()->getModule());
    $neolog->setAction($toolkit->getRequest()->getAction());
    $neolog->setUserId($toolkit->getUser()->getId());
    $neolog->setUsername($toolkit->getUser()->getName());
    $neolog->setChanges($changes);
    $neolog->setExtendedInfo($err_content);
    $neologMapper->save($neolog);
}

/**
* Add info to update log
*
* @param int $site_id
* @param int $up_id
* @param mixed $action
* @param mixed $info
*/
function uLog($site_id, $up_id, $action, $info)
{
    $toolkit = systemToolkit::getInstance();
    $updateLogMapper = $toolkit->getMapper('update', 'updateLog');

    $log = $updateLogMapper->create();
    $log->setSiteId($site_id);
    $log->setUpId($up_id);
    $log->setAction($action);
    $log->setInfo($info);
    $log->setTime(new SQLFunction("UNIX_TIMESTAMP"));

    $updateLogMapper->save($log);
}

/**
* Get folder for file uploading
*
* @return fileManagerFolder
*/
function getFolder($name)
{
    $fileManagerFolderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder');
    $folder = $fileManagerFolderMapper->searchByPath($name);
    if (!$folder) {
        $folder = $fileManagerFolderMapper->create();
        $folder->setName($name);
        $folder->setTitle($name);
        $fileManagerFolderMapper->save($folder);
    }
    return $folder;
}

/**
* Serialization function based on standart serialize() function but with base64 encode
*
* @author GreeveX <greevex@gmail.com>
*
* @param array $data
* @param bool $base64
*
* @return string
*/
function my_serialize($data, $base64 = false)
{
    $output = "";
    if(is_array($data)) {
        $type = 'array';
    } elseif(is_int($data)) {
        $type = 'int';
    } elseif(is_float($data)) {
        $type = 'float';
    } else {
        $type = 'string';
    }
    switch($type) {
        case 'array':
            $output .= 'a:' . count($data) . ':{';
            foreach($data as $key => $value) {
                $output .= my_serialize($key, $base64);
                $output .= my_serialize($value, $base64);
            }
            $output .= '}';
            break;
        case 'int':
            $output .= 'i:';
            $output .= intval($data);
            $output .= ';';
            break;
        case 'float':
            $output .= 'd:';
            $output .= str_replace(',', '.', (string)floatval($data));
            $output .= ';';
            break;
        case 'string':
            $data = $base64 ? base64_encode($data) : $data;
            $output .= 's:' . strlen($data) . ':"';
            $output .= (string)$data;
            $output .= '";';
            break;
    }
    return $output;
}

/**
* Log some data to file
*
* @param string $filename
* @param string $data
* @param string $mode
*/
function logToFile($filename, $data, $mode = 'a')
{
    try {
        $fp = fopen($filename, $mode);
        fwrite($fp, $data);
        fclose($fp);
        return true;
    } catch(Exception $e) {
        if(function_exists('logMe')) {
            logMe("Error on writing to file «{$filename}» some data!", 3, array($e->getMessage(), $data));
        }
        return false;
    }
}

/**
* Create || update process
*
* @param string $status
* @param float $percent
* @param int $pid
* @param string $name
*
* @return int $pid
*/
function process($status, $percent, $pid = "auto", $name = "")
{
    $toolkit = systemToolkit::getInstance();
    $processMapper = $toolkit->getMapper('process', 'process');
    $process = false;
    if($pid != "auto") {
        $process = $processMapper->searchOneByField('pid', $pid);
        if(!$process) {
            if(function_exists('logMe')) {
                logMe("Can't find process with pid «{$pid}»!", 4);
            }
        }
    }
    if(!$process) {
        $process = true;
        while(true) {
            $pid = rand(0,4294967294);
            $process = $processMapper->searchOneByField('pid', $pid);
            if(!$process) {
                break;
            }
        }
        $process = $processMapper->create();
        $process->setPid($pid);
    }
    $process->setName($name);
    $process->setModule($toolkit->getRequest()->getModule());
    $process->setAction($toolkit->getRequest()->getAction());
    $process->setUserId($toolkit->getUser()->getId());
    $process->setStatus($status);
    $process->setPercent((float)$percent);
    $processMapper->save($process);
    return $process->getPid();
}

/**
* Kill process by process ID
*
* @param int $pid
*/
function killProcess($pid)
{
    $mapper = systemToolkit::getInstance()->getMapper('process', 'process');
    $process = $mapper->searchOneByField('pid', $pid);
    if($process) {
        $mapper->delete($process);
    }
}

function convertSize($size)
{
    try {
        $unit=array('B','KB','MB');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),3).' '.$unit[$i];
    } catch(Exception $e) { return "N/A"; }
}
?>