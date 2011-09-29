<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function clearCache($folder, $echo = false) {
    $fp = @opendir($folder);
    while (false !== ($file = readdir($fp))) {
        if($file != '.' && $file != '..' && $file != ".svn") {
            if(!unlink($folder . "/" . $file)) {
                if($echo) echo "\n{$file} is not deleted!";
            } else {
                if($echo) echo "\n{$file} deleted!";
            }
        }
    }
    return true;
}

clearCache("./websys/tmp/cache");
clearCache("./websys/tmp/templates_c");
if(isset($_REQUEST['sessions'])) {
    clearCache("./websys/tmp/sessions");
}

header('Location: /');
die();
?>