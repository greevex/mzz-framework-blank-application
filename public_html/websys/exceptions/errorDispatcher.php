<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/exceptions/errorDispatcher.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage exceptions
 * @version $Id: errorDispatcher.php 3750 2009-09-25 04:36:43Z zerkms $
*/

/**
 * errorDispatcher: класс для работы с PHP-ошибками и исключениями
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1.2
 */
class errorDispatcher
{
    protected $exception;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
    }

    /**
     * Обработчик PHP-ошибок.
     *
     * @param integer $errno номер ошибки
     * @param string $errstr текст ошибки
     * @param string $errfile имя файла, в котором обнаружена ошибка
     * @param integer $errline номер строки, в которой обнаружена ошибка
     * @throws phpErrorException
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if(error_reporting() && $errno != E_STRICT) {
            throw new phpErrorException($errno, $errstr, $errfile, $errline);
        }
    }

    /**
     * Обработчик исключений
     *
     * @param exception $exception
     */
    public function exceptionHandler($exception)
    {
        $this->exception = $exception;
        try {
            $this->mailException();
        } catch (Exception $e) { echo $e->getMessage();
            echo 'Ошибка при отсылке сообщения об ошибке';
        }
        $this->outputException();
    }

    /**
     * Устанавливает обработчик PHP-ошибок и исключений
     *
     * @param errorDispatcher $dispatcher обработчик
     */
    public static function setDispatcher($dispatcher)
    {
        set_error_handler(array($dispatcher, 'errorHandler'));
        set_exception_handler(array($dispatcher, 'exceptionHandler'));
    }

    /**
     * Восстанавливает стандартные обработчики PHP-ошибок и исключений
     *
     */
    public function restroreDispatcher()
    {
        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * Вывод исключения
     *
     */
    public function outputException()
    {
        $debug_mode = DEBUG_MODE;
        $exception = $this->exception;
        $system_info = array(
            'sapi' => php_sapi_name(),
            'software' => (!empty($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'unknown'),
            'php' => PHP_VERSION . ' on ' . PHP_OS,
            'mzz' => MZZ_VERSION . ' (Rev. ' . MZZ_REVISION . ')'
        );

        include(systemConfig::$pathToSystem  . '/exceptions/templates/exception.tpl.php');
    }

    /**
     * Вывод исключения
     *
     */
    public function captureException()
    {
        ob_start();
        $this->outputException();
        return ob_get_clean();
    }

    public function plainException()
    {
        $exception = $this->exception;
        $content = "Application was halted by an exception (mzz.";
        $content .= (method_exists($exception, 'getName')) ? $exception->getName() : "Unknown name\r\n";


        if ($exception->getCode() != 0) {
            $content .= "[Code: " . $exception->getCode() . "] ";
        }
        $content .= $this->exception->getMessage();
        $content .= $exception->getFile() . ', Line: ' . $exception->getLine() . "\r\n\r\n";


        if (($traces = $exception->getPrevTrace()) === null) {
            $traces = $exception->getTrace();
        }

        $count = $total = count($traces);
        foreach ($traces as $trace) {
            if (!isset($trace['file'])) {
                $trace['file'] = 'unknown';
            }
            if (!isset($trace['line'])) {
                $trace['line'] = 'unknown';
            }

            $count--;
            $content .= $count . '. ';
            $args = '';
            if (!isset($trace['args'])) {
                $trace['args'] = $trace;
            }
            foreach ($trace['args'] as $arg) {
                $args .= $exception->convertArgToString($arg) . ', ';
            }
            $args = substr($args, 0, strlen($args) - 2);

            $content .= 'At ';
            if (isset($trace['class']) && isset($trace['type'])) {
                $content .= $trace['class'] . $trace['type'] . $trace['function'] . '(' . $args . ')';
            } else {
                $content .= $trace['function'] . '(' . $args . ')';
            }
            $content .= '; In: ' . $trace['file'] . ':' . $trace['line'] . "\r\n";
        }
        return $content;

    }

    public function mailException()
    {
        $new = false;
        $exception = $this->exception;
        $log = $this->getLog();
        //$content = "[{$exception->getCode()}] " . $this->exception->getMessage() . ', File: ' .  $exception->getFile() . ', Line: ' . $exception->getLine() . "\n";
        $content = $this->captureException();
        if (!isset($log[md5($content)])) {
            $log[md5($content)]['content'] = $content;
            $log[md5($content)]['date'] = time();
            $new = true;
        }
        if ($new || time() - $log[md5($content)]['date'] > 60 * 60 * 4) {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $mailContent = $log[md5($content)]['content'];
                $mailContent .= "\r\n\r\n";
                if (isset($_SESSION['user_id'])) {
                    $mailContent .= "ID пользователя: {$_SESSION['user_id']}";
                    if (!empty($_SESSION['user_name'])) {
                        $mailContent .= " ({$_SESSION['user_name']})";
                    }
                } else {
                    $mailContent .= "ID пользователя: гость или cron";
                }

                $mailContent .= "\r\n";
                if (isset($_SERVER['QUERY_STRING'])) {
                    $mailContent .= "QUERY_STRING: {$_SERVER['QUERY_STRING']}";
                }
                fileLoader::load('service/mailer/mailer');
                $mailer = mailer::factory();
                foreach (AppSystemConfig::$administrators as $name => $admin) {
                    $mailer->set(
                             $admin['email'],
                             $admin['name'],
                             systemConfig::$mailer['default']['params']['smtp_user'],
                             systemConfig::$mailer['default']['params']['default_topic'],
                             systemConfig::$appName . " v" . systemConfig::$appVersion . " Exception",
                             $mailContent
                             );

                    $mailer->send();
                }
            }
            $log[md5($content)]['date'] = time();
        }

        $path = systemConfig::$pathToTemp . '/last_sent_exceptions';
        file_put_contents($path, json_encode($log));
    }

    public function getLog()
    {
        $path = systemConfig::$pathToTemp . '/last_sent_exceptions';
        if (!file_exists($path)) {
            return array();
        }
        return json_decode(file_get_contents($path), true);
    }

}

?>