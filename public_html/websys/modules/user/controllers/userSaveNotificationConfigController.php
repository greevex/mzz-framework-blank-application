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

fileLoader::load('user/models/notificationEvents');

/**
 * userSaveNotificationConfigController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userSaveNotificationConfigController extends simpleController
{
    protected function getView()
    {
        $notificationConfigMapper = $this->toolkit->getMapper('user', 'notificationConfig');
        $userMapper = $this->toolkit->getMapper('user', 'user');

        $action = $this->request->getAction();

        $isEdit = strpos($action, 'edit') !== false;

        if ($isEdit) {
            $id = $this->request->getInteger('id');
            $notificationConfig = $notificationConfigMapper->searchByKey($id);
            if (empty($notificationConfig)) {
                return $this->forward404($notificationConfigMapper);
            }
        } else {
            $notificationConfig = $notificationConfigMapper->create();
        }

        $validator = new formValidator();

        if (!$isEdit) {
            $validator->rule('required', 'notificationConfig[user_id]', 'Field user_id is required');
        }
        $validator->rule('required', 'notificationConfig[event]', 'Field event is required');
        $validator->rule('callback', 'notificationConfig[event]', 'Такое событие уже привязано к пользователю', array(array($this, 'checkUnique'), $notificationConfigMapper, $notificationConfig));

        if ($validator->validate()) {
            $data = $this->request->getArray('notificationConfig', SC_POST);

            if (!$isEdit) {
                $notificationConfig->setUser($data['user_id']);
            }
            $notificationConfig->setEvent($data['event']);

            $notificationConfigMapper->save($notificationConfig);

            return jipTools::redirect();
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
        $this->view->assign('notificationConfig', $notificationConfig);
        $this->view->assign('isEdit', $isEdit);
        $this->view->assign('events', notificationEventRegistry::getEvents());
        $this->view->assign('users', $userMapper->searchAll());

        return $this->render('user/saveNotificationConfig.tpl');
    }

    public function checkUnique($event, $notificationConfigMapper, $notificationConfig)
    {
        if ($notificationConfig->getId() && $notificationConfig->getEvent() == $event) {
            return true;
        }

        $criteria = new criteria();
        if ($notificationConfig->getId()) {
            $user_id = $notificationConfig->getUser()->getId();
        } else {
            $user_id = $this->request->getString('notificationConfig[user_id]', SC_POST);
        }
        $criteria->where('user_id', $user_id);
        $criteria->where('event', $event);

        $config = $notificationConfigMapper->searchOneByCriteria($criteria);
        return is_null($config);
    }
}

?>