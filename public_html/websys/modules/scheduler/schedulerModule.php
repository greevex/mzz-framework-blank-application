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
 * schedulerModule
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerModule extends simpleModule
{
    protected $classes = array('schedulerTask');

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

    public function getRoutes()
    {
        return array(
            array(
                'schedulerTaskStatus' => new requestRoute('scheduler/:id/:status/:action',
                    array('module' => 'scheduler',
                          'action' => 'changeTaskStatus',
                          'id' => '',
                          'status' => ''
                          ),
                    array('id' => '\d+',
                          'status' => '\d+',
                          'action' => '(?:changeTaskStatus)')),

                ),
            array(),
        );
    }
}
?>
