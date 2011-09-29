<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/module.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: module.tpl 4004 2009-11-24 00:10:39Z mz $
 */

/**
 * blogModule
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogModule extends simpleModule
{
    protected $classes = array('blog', 'tags', 'tagsComp', 'watch');

	protected $roles = array(
                            'guest',
                            'user',
                            'root',
                            );


    protected $moduleTitle = 'Блог';

	public function getRoutes()
    {
        return array(
			array(),
            array(
				'blog' => new requestRoute('blog/:action/:id', array('module' => 'blog', 'action' => 'list', 'id' => '')),
				),
		);
	}
}
?>