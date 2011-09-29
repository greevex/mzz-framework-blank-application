<?php
set_time_limit(0);
@ini_set('implicit_flush', 1);
@ini_set('output_buffering', 1);

define('DEBUG_MODE', true);

if(!ini_get('mbstring.internal_encoding')) {
    ini_set('mbstring.internal_encoding', 'UTF-8');
}

require_once './websys/config.php';
require_once systemConfig::$pathToSystem . '/index.php';
require_once './websys/application.php';

if(DEBUG_MODE) {
    error_reporting(E_ALL);
    @ini_set('display_errors', 1);
}

$application = new application();
$application->run();
?>