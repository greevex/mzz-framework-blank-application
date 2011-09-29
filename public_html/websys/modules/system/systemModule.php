<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/module.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: module.tpl 4245 2010-06-09 14:12:18Z bobr $
 */

/**
 * systemModule
 *
 * @package modules
 * @subpackage system
 * @version 0.0.1
 */
class systemModule extends simpleModule
{
    protected $classes = array('feedback');
	protected $roles = array();

	protected $version = '0.0.1';

	protected $icon = null;

	/**
     * Returns array of requirements or empty array if all ok
     *
     * @return array
     */
    public function checkRequirements()
    {
        return array();
    }
}
?>
