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
 * logLogListController
 *
 * @package modules
 * @subpackage log
 * @version 0.0.1
 */
class logLogListController extends simpleController
{
    protected function getView()
    {
        $process_id = $this->request->getInteger('process', SC_REQUEST);
        $status = $this->request->getInteger('status', SC_REQUEST);
        $user_id = $this->request->getInteger('user_id', SC_REQUEST);
        $time = $this->request->getInteger('time', SC_REQUEST);
        $per_page = $this->request->getInteger('per_page', SC_REQUEST);

        $action_filter = $this->request->getString('action_filter', SC_REQUEST);
        $module_filter = $this->request->getString('module_filter', SC_REQUEST);
        $comment_filter = $this->request->getString('comment_filter', SC_REQUEST);

        $logMapper = $this->toolkit->getMapper('log', 'log');
        $processMapper = $this->toolkit->getMapper('process', 'process');
        $updateMapper = $this->toolkit->getMapper('update', 'update');
        $updateLogMapper = $this->toolkit->getMapper('update', 'updateLog');

        $processes = $processMapper->searchAll();
        $updates = $updateMapper->searchAll();

        $processList = array();
        foreach ($processes as $process) {
            $processList[$process->getId()] = $process->getModule() . '/' . $process->getAction();
        }

        $this->setPager($logMapper, $per_page ? $per_page : 20);

        $criteria = new criteria();

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $users = $userMapper->searchAll();
        $users_flatten = array();
        foreach ($users as $user) {
            $users_flatten[$user->getId()] = $user->getName();
        }


        if ($process_id) {
            $criteria->where('process_id', $process_id);
        }
        if ($status) {
            $criteria->where('status', $status);
        }
        if ($user_id) {
            $criteria->where('user_id', $user_id);
        }
        if ($time && $time > 1) {
            $criteria->where('time', time() - $time, criteria::GREATER_EQUAL);
        }

        if (!empty($action_filter)) {
            $criteria->where('action', $action_filter, criteria::LIKE);
        }

        if (!empty($module_filter)) {
            $criteria->where('module', $module_filter, criteria::LIKE);
        }

        if (!empty($comment_filter)) {
            $criteria->where('comment', $comment_filter, criteria::LIKE);
        }

        $all = $logMapper->searchAllByCriteria($criteria);

        $this->view->assign('all', $all);
        $this->view->assign('processes', $processList);
        $this->view->assign('process', $process_id);
        $this->view->assign('status', $status);
        $this->view->assign('users', $users_flatten);
        $this->view->assign('user_id', $user_id);
        $this->view->assign('time', $time);
        $this->view->assign('per_page', $per_page);
        $this->view->assign('comment_filter', $comment_filter);
        $this->view->assign('action_filter', $action_filter);
        $this->view->assign('module_filter', $module_filter);

        return $this->render('log/logList.tpl');
    }
}

?>