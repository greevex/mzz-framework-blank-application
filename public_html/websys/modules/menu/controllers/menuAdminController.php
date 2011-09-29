<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/menu/controllers/menuAdminController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: menuAdminController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * menuAdminController: контроллер для метода admin модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuAdminController extends simpleController
{
    protected function getView()
    {
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');
        $menuFolderMapper = $this->toolkit->getMapper('menu', 'menuFolder');
        $folder = $menuFolderMapper->getFolder();
        $menus = $menuMapper->searchAll();

        $this->view->assign('menus', $menus);
        $this->view->assign('folder', $folder);
        return $this->render('menu/admin.tpl');
    }
}

?>