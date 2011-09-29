<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/controller.save.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.save.tpl 4201 2010-04-12 11:27:49Z desperado $
 */

/**
 * notificationAddController
 *
 * @package modules
 * @subpackage notification
 * @version 0.0.1
 */
class notificationAddController extends simpleController
{
    protected function getView()
    {
        $notificationMapper = $this->toolkit->getMapper('notification', 'notification');

        $action = $this->request->getAction();

        $isEdit = strpos($action, 'edit') !== false;

        if ($isEdit) {
            $id = $this->request->getInteger('id');
            $notification = $notificationMapper->searchByKey($id);
            if (empty($notification)) {
                return $this->forward404($notificationMapper);
            }
        } else {
            $notification = $notificationMapper->create();
        }

        $validator = new formValidator();

        $validator->rule('required', 'notification[title]', 'Field title is required');
        $validator->rule('required', 'notification[content]', 'Field content is required');
        $validator->rule('required', 'notification[date_start]', 'Field date_start is required');
        $validator->rule('required', 'notification[date_end]', 'Field date_end is required');

        if ($validator->validate()) {
            $data = $this->request->getArray('notification', SC_POST);

            $notification->setUser($this->toolkit->getUser()->getId());
            $notification->setTitle($data['title']);
            $notification->setContent($data['content']);
            $notification->setDateStart(strtotime($data['date_start']));
            $notification->setDateEnd(strtotime($data['date_end']));

            $notificationMapper->save($notification);

            $url = new url('default2');
            $url->setAction('list');
            return jipTools::redirect($url->get());
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $id);
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);

        $this->view->assign('form_action', $url->get());
        $this->view->assign('validator', $validator);
        $this->view->assign('notification', $notification);
        $this->view->assign('isEdit', $isEdit);

        return $this->render('notification/add.tpl');
    }
}

?>