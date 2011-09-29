<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * blogUpdateModulesController
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogUpdateModulesController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $watchMapper = $this->toolkit->getMapper('blog', 'watch');

        $modules = $adminMapper->getModules();
        
        $i = 0;
        
        foreach ($modules as $module) {
           if (!$module->isSystem()) {
               $m = $watchMapper->searchOneByField('name', $module->getName());
               if(!$m) {
                    $m = $watchMapper->create();
                    $m->setName($module->getName());
                    $watchMapper->save($m);
                    $i++;
               }
           }
        }
        
        return "Ready! " . $i . " modules added.";
    }
}
?>