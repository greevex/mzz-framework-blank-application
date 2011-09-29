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
* @link http://www.mzz.ru
* @package system
* @subpackage core
* @version 0.2
*/

require_once "public_html/websys/config.php";
require_once systemConfig::$pathToSystem . "/index.php";
require_once systemConfig::$pathToApplication . "/consoleApplication.php";

/**
* consoleHelloWorld
*
* Console Application Hello World
*
* @package system
* @subpackage application
* @version 1.0
* @author GreeveX <greevex@gmail.com>
*/
class consoleHelloWorld extends consoleApplication
{
    /**
    * Application configs
    *
    * Name, Title and allow or deny much of instances for this application.
    */
    protected $consoleConfig = array(
        'application_name' => "Console Application Hello World",
        'application_title' => "ConsoleApp HelloWorld",
        'only_one_instance' => false
    );

    /**
    * Main method
    *
    */
    protected function handleMain()
    {
        console::writeLine("Hello, world!");
    }
}

$app = new consoleHelloWorld();
$app->run();
?>