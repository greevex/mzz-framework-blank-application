<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/user/controllers/userAdminController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userAdminController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * userAdminController: контроллер для метода admin модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userAdminController extends simpleController
{
    protected function getView()
    {
        $userFolderMapper = $this->toolkit->getMapper('user', 'userFolder');
        $groupFolderMapper = $this->toolkit->getMapper('user', 'groupFolder');

        $userFolder = $userFolderMapper->getFolder();
        $groupFolder = $groupFolderMapper->getFolder();

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $this->setPager($userMapper);

        $this->view->assign('userFolder', $userFolder);
        $this->view->assign('groupFolder', $groupFolder);
        $this->view->assign('section_name', $this->request->getString('section_name'));
        $this->view->assign('users', $userMapper->searchAll());
        return $this->render('user/admin.tpl');
    }
}

?>