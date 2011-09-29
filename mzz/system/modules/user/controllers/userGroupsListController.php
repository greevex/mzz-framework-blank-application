<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/user/controllers/userGroupsListController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userGroupsListController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * userGroupsListController: контроллер для метода groupsList модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.1
 */
class userGroupsListController extends simpleController
{
    protected function getView()
    {
        $groupFolderMapper = $this->toolkit->getMapper('user', 'groupFolder');
        $groupFolder = $groupFolderMapper->getFolder();

        $userFolderMapper = $this->toolkit->getMapper('user', 'userFolder');
        $userFolder = $userFolderMapper->getFolder();

        $groupMapper = $this->toolkit->getMapper('user', 'group');

        $this->setPager($groupMapper, 10, true);

        $this->view->assign('groups', $groupMapper->searchAll());
        $this->view->assign('userFolder', $userFolder);
        $this->view->assign('groupFolder', $groupFolder);

        return $this->render('user/groupsList.tpl');
    }
}

?>