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
 * notificationListController
 *
 * @package modules
 * @subpackage notification
 * @version 0.0.1
 */
class notificationListController extends simpleController
{
    protected function getView()
    {
        $notificationMapper = $this->toolkit->getMapper('notification', 'notification');

        $onlyActual = $this->request->getBoolean('onlyActual');
        $criteria = new criteria;
        if(!$onlyActual) {
            $this->setPager($notificationMapper);
            $all = $notificationMapper->searchAllByCriteria($criteria);
        } else {
            $all = $notificationMapper->searchUnread(true);
        }
        $this->view->assign('all', $all);
        return $this->render('notification/list.tpl');
    }
}

?>