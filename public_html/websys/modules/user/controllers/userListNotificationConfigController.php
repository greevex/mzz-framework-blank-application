<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/controller.list.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.list.tpl 4201 2010-04-12 11:27:49Z desperado $
 */

/**
 * userListNotificationConfigController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userListNotificationConfigController extends simpleController
{
    protected function getView()
    {
        $notificationConfigMapper = $this->toolkit->getMapper('user', 'notificationConfig');

        $this->setPager($notificationConfigMapper);

        $all = $notificationConfigMapper->searchAll();

        $this->view->assign('all', $all);
        return $this->render('user/listNotificationConfig.tpl');
    }
}

?>