<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/access/accessModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: accessModule.php 4060 2010-02-05 09:53:59Z desperado $
 */

/**
 * accessModule
 *
 * @package modules
 * @subpackage access
 * @version 0.0.1
 */
class accessModule extends simpleModule
{
    protected $classes = array('access');

    protected $roles = array('admin');

    public function isSystem()
    {
        return true;
    }
}
?>