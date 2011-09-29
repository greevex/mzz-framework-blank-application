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
 * deleterModule
 *
 * @package modules
 * @subpackage deleter
 * @version 0.0.1
 */
class deleterModule extends simpleModule
{
    protected $classes = array('deleter');
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

    /**
    * Adding routes
    *
    * @return array
    */
    public function getRoutes()
    {
        return array(
            array(),
            array(
                'deleter' => new requestRoute('deleter/:module_name/:class/:field/:value/:original_action',
                    array('module' => 'deleter', 'action' => 'delete' ))
                ));
    }
}
?>
