<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/exceptions/mzzUnknownCacheBackendException.php $
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
 * @version $Id: mzzUnknownCacheBackendException.php 2555 2008-07-10 21:21:03Z mz $
*/

/**
 * mzzUnknownCacheBackendException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/

class mzzUnknownCacheBackendException extends mzzException
{
    public function __construct($driverName)
    {
        $message = "Cache driver '" . $driverName . "' not found";
        parent::__construct($message);
    }
}

?>