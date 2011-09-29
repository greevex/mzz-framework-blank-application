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
 * schedulerChangeTaskStatusController
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerChangeTaskStatusController extends simpleController
{
    protected function getView()
    {
        $task_id = $this->request->getInteger('id');
        $status = $this->request->getInteger('status');
        $taskMapper = $this->toolkit->getMapper('scheduler', 'schedulerTask');
        $task = $taskMapper->searchByKey($task_id);

        if (!$task) {
            return $this->forward404($task);
        };

        switch (true) {
            case $status === 0 && (int)$task->getStatus() !== 0:
            case $status === 1 && (int)$task->getStatus() !== 3:
                $task->setStatus($status);
                $taskMapper->save($task);
                $url = new url('default2');
                $url->setModule('scheduler');
                $url->setAction('listTask');
                return jipTools::refresh($url->get());
                break;
            default:
                return $this->forward404($task);
        }

        return $this->render('scheduler/changeTaskStatus.tpl');
    }
}
?>