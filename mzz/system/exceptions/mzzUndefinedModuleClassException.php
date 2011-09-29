<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/exceptions/mzzUndefinedModuleClassException.php $
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
 * @version $Id: mzzUndefinedModuleClassException.php 3750 2009-09-25 04:36:43Z zerkms $
*/

/**
 * mzzUndefinedModuleClassException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/
class mzzUndefinedModuleClassException extends mzzException
{
    public function __construct($module, $className)
    {
        parent::__construct('Class ' . $className . ' not found in module ' . $module);
    }
}

?>