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
 * processModule
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processModule extends simpleModule
{
    protected $classes = array('process', 'processTask');
	protected $roles = array(
                            'guest',
                            'user',
                            'root',
                            'it-bitrix',
                            'it-1c',
                            'it-mzz',
                            'content-view',
                            'content-edit',
                            'marketing',
                            'network-marketing',
                            'presidium',
                            'saler',
                            'hr',
                            'accounting',
                            'partner',
                            'logist',
                            'aho',
                            'warehouse',
                            'internal-control',
                            'product-update',

                            'department-head',
                            'photo',
                            'content-upload',
                            'beginner',
                            'operational-work',
                            'remains-update',
                            'price-update',
                            );


    protected $moduleTitle = 'Процессы';

    protected $version = '1.0';

    protected $icon = "sprite:sys/page";

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
                'process' => new requestRoute('process/:action/:id',
                    array('module' => 'process', 'action' => 'listProcess', 'id' => '')),
                ));
    }

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
