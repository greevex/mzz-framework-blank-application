<?php
/**
* $URL$
*
* MZZ Content Management System (c) 2006
* Website : http://www.mzz.ru
*
* This program is free software and released under
* the GNU/GPL License (See /docs/GPL.txt).
*
* consoleApplication: консольное приложение
*
* @link http://www.mzz.ru
* @package system
* @subpackage core
* @version 0.3
* @author striker <wiistriker@gmail.com>
* @author greevex <greevex@gmail.com>
*/

abstract class consoleApplication extends core
{
    const BUSY_STATE_FREE = 0;
    const BUSY_STATE_BUSY = 1;

    protected $log_file_handler = null;

    protected $consoleConfig = array(
        'application_name' => "consoleApplication1",
        'application_title' => "consoleApplication1",
        'only_one_instance' => false
    );

    abstract protected function handleMain();

    /**
    * Main operation method
    *
    */
    protected function handle()
    {
        errorDispatcher::setDispatcher(new consoleApplicationErrorDispatcher($this));

        fileLoader::load("timer");
        fileLoader::load("/service/userFunctions.php");

        $timer = new timer();
        $timer->start();

        console::writeLine("Start app at " . date("c"));

        if ($this->isOnlyOneInstance()) {
            if (!$this->isBusy()) {
                $this->writeLog("Change work state to busy");
                $this->changeBusyState(self::BUSY_STATE_BUSY);

                try {
                    $this->handleMain();
                } catch (Exception $e) {
                    $this->writeLog("Main handler exception in " . $e->getFile() . ":" . $e->getLine() . " (" . $e->getMessage() . ")");
                }

                $this->writeLog("Change work state to free");
                $this->changeBusyState(self::BUSY_STATE_FREE);
            } else {
                $this->writeLog("Another work in progress");
            }
        } else {
            try {
                $this->handleMain();
            } catch (Exception $e) {
                $this->writeLog("Main handler exception in " . $e->getFile() . ":" . $e->getLine() . " (" . $e->getMessage() . ")");
            }
        }

        $timer->finish();
        $this->writeLog("Time estimated: " . round($timer->getPeriod(), 5) . " seconds");
    }

    public function __destruct()
    {
        if ($this->log_file_handler) {
            fclose($this->log_file_handler);
        }
    }

    public function isLoggingToFile()
    {
        return false;
    }

    public function writeLog($message, $timestamp = true)
    {
        console::writeLine($message, $timestamp);

        if ($this->isLoggingToFile()) {
            if (!$this->log_file_handler) {
                $this->initLogFile();
            }

            fwrite($this->log_file_handler, date('H:i:s') . '  ' . $message . "\r\n");
        }
    }

    protected function initLogFile()
    {
        $log_file_folder = systemConfig::$application['PATH_TO_CONSOLE_LOGS'] . DIRECTORY_SEPARATOR . date('Ymd') . DIRECTORY_SEPARATOR;
        if (!is_dir($log_file_folder)) {
            mkdir($log_file_folder, 0777);
            chmod($log_file_folder, 0777);
        }

        $log_file_path = $log_file_folder . $this->getLogFileName();

        $log_file = fopen($log_file_path, 'a+');
        chmod($log_file_path, 0777);

        $this->log_file_handler = $log_file;
    }

    protected function getLogFileName()
    {
        return $this->getName() . "_" . date("H-i-s") . ".log";
    }

    public function getName()
    {
        return $this->consoleConfig['application_name'];
    }

    public function getTitle()
    {
        return $this->consoleConfig['application_title'];
    }

    public function isOnlyOneInstance()
    {
        return $this->consoleConfig['only_one_instance'];
    }

    public function getStatusIdent()
    {
        return $this->getName();
    }

    protected function isBusy()
    {
        $lock_file_path = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . $this->getStatusIdent() . '.lock';
        return file_exists($lock_file_path);
    }

    protected function changeBusyState($state)
    {
        $lock_file_path = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . $this->getStatusIdent() . '.lock';

        if ($state == self::BUSY_STATE_BUSY) {
            $lock_file = fopen($lock_file_path, 'a+');
            fclose($lock_file);

            chmod($lock_file_path, 0777);
        } elseif ($state == self::BUSY_STATE_FREE) {
            unlink($lock_file_path);
        }
    }

    protected function composeFilters($filter_chain)
    {
        return $filter_chain;
    }

    /**
     * Загрузка минимально необходимого для функционирования набора файлов
     *
     */
    protected function loadCommonFiles()
    {
        fileLoader::load('exceptions/init');
        fileLoader::load('service/arrayDataspace');
        fileLoader::load('request/init');
        fileLoader::load('orm/init');
        fileLoader::load('simple/init');
        fileLoader::load('filters/init');
        fileLoader::load('i18n/init');
        fileLoader::load('db/init');
        fileLoader::load('toolkit/init');
        fileLoader::load('forms/init');
    }
}

class consoleApplicationErrorDispatcher
{
    protected $app;

    public function __construct(consoleApplication $app)
    {
        $this->app = $app;
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (error_reporting() && $errno != E_STRICT) {
            throw new phpErrorException($errno, $errstr, $errfile, $errline);
        }
    }

    public function exceptionHandler($e)
    {
        $this->app->writeLog("Uncaught exception in " . $e->getFile() . ":" . $e->getLine() . " (" . $e->getMessage() . ")");
    }
}

?>