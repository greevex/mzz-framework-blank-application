<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/exceptions/mzzUnknownCacheConfigException.php $
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
 * @version $Id: mzzUnknownCacheConfigException.php 2555 2008-07-10 21:21:03Z mz $
*/

/**
 * mzzUnknownCacheConfigException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/

class mzzUnknownCacheConfigException extends mzzException
{
    public function __construct($configName)
    {
        $message = "Cache backend config '" . $configName . "' not found";
        parent::__construct($message);
    }
}

?>