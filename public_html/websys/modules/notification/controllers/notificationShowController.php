<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * notificationShowController
 *
 * @package modules
 * @subpackage notification
 * @version 0.0.1
 */
class notificationShowController extends simpleController
{
    protected function getView()
    {
        $this->view->disableMain();

        $action = $this->request->getAction();
        switch($action) {
            case "show":
                $notificationMapper = $this->toolkit->getMapper('notification', 'notification');
                $notification = $notificationMapper->searchUnread();
                
                if ($notification) {
                    $this->view->assign('title', $notification->getTitle());
                    $this->view->assign('content', $notification->getContent());
                    $this->view->assign('author', $notification->getUser());
                    $this->view->assign('id', $notification->getId());
                }
                break;
            case "close":
                $id = $this->request->getInteger('id');
                $notificationReadMapper = $this->toolkit->getMapper('notification', 'read');
                $notificationReadMapper->read($id);
                break;
        }
        return $this->render('notification/show.tpl');
    }
}
?>