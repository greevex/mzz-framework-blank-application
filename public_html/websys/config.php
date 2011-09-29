<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/apps/demo/trunk/config.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: config.php 4059 2010-02-05 09:45:52Z desperado $
*/

/**
 * Абсолютный путь до сайта.
 * Если mzz установлен в корень веб-сервера, оставьте поле пустым
 * Правильно: /mzz, /new/site
 * Неправильно: site1, site1/, /site1/
 *
 */
define('SITE_PATH', '');
define('COOKIE_DOMAIN', '');

if(!defined('DEBUG_MODE')) {
    define('DEBUG_MODE', false);
}

define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../../mzz/system'));

/**
 * Идентификатор записи в БД для неавторизированных пользователей
 */
define('MZZ_USER_GUEST_ID', 1);

/**
 * Идентификатор группы, для которой ACL всегда будет возвращать true (т.е. предоставит полный доступ)
 */
define('MZZ_ROOT_GID', 3);

require_once realpath(dirname(__FILE__)) . '/systemConfig.php';

// включаем мультиязычность
systemConfig::$i18nEnable = false;

// дефолтный язык приложения
systemConfig::$i18n = 'ru';

// устанавливаем дефолтную кодировку для выдачи
ini_set('default_charset', 'utf-8');

systemConfig::$db['default']['host']        = 'localhost';
systemConfig::$db['default']['dbname']      = 'db_aworld';
systemConfig::$db['default']['user']        = 'dbu_aworld';
systemConfig::$db['default']['password']    = 'gy345yGFh!3';
systemConfig::$db['default']['driver']      = 'pdo';
systemConfig::$db['default']['dbtype']      = 'mysql';
systemConfig::$db['default']['dsn']         = systemConfig::$db['default']['dbtype'] . ':host=' . systemConfig::$db['default']['host'] . ';dbname=' . systemConfig::$db['default']['dbname'];
systemConfig::$db['default']['options']     = array(
                                                'init_query' => "SET NAMES `utf8`",
                                                );

systemConfig::$appName = 'Artificial World';
systemConfig::$appVersion = '0.1';
systemConfig::$administrator = 'GreeveX';
systemConfig::$administratorEmail = 'greevex@gmail.com';

class AppSystemConfig extends systemConfig
{
    static $administrators;
}

AppSystemConfig::$administrators = array();
AppSystemConfig::$administrators['greevex']['name'] = 'GreeveX';
AppSystemConfig::$administrators['greevex']['email'] = 'greevex@gmail.com';
systemConfig::$enabledModules = array(
                                      'menu',
                                      'page',
                                      'fileManager',
                                      'blog',
                                      'comments',
                                      'log',
                                      'process',
                                      'deleter',
                                      'scheduler',
                                      'system',
                                      'notification',
                                      'privateMessage',
                                     );
systemConfig::$pathToApplication = dirname(__FILE__);
systemConfig::$pathToWebRoot = realpath(systemConfig::$pathToApplication . '/..');
systemConfig::$pathToTemp = realpath(dirname(__FILE__) . '/tmp');
systemConfig::$pathToConfigs = realpath(dirname(__FILE__) . '/configs');

systemConfig::$mailer['default']['backend'] = 'PHPMailer';
systemConfig::$mailer['default']['params'] = array(
                                                    'default_topic' => systemConfig::$appName . " v" . systemConfig::$appVersion,
                                                    'html' => true,
                                                    'smtp' => true,
                                                    'smtp_host' => 'smtp.ya.ru',
                                                    'smtp_user' => 'robot@greevex.ru',
                                                    'smtp_pass' => '6rhEOHZcZf',
                                                    'smtp_port' => 25
                                                  );

systemConfig::$cache['default']['backend'] = "file"; // memcache required on production

systemConfig::$cache['default']['params'] = array(
                                                    'path' => systemConfig::$pathToTemp . '/cache'
                                                    );

/* Memcache *
systemConfig::$cache['default']['params'] = array(
                                                    'servers' => array(
                                                                        '127.0.0.1' => array('port' => '11211')
                                                                        ),
                                                    );
/**/

systemConfig::init();

?>
