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
 * schedulerRunTaskController
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerRunTaskController extends simpleController
{
    protected function getView()
    {
        $taskMapper = $this->toolkit->getMapper('scheduler', 'schedulerTask');

        $result = array();
        foreach ($taskMapper->searchAllActive() as $task) {
            if ($task->shouldBeRunned()) {
                $result[$task->getId()] = $task;
                $task->setRunning();
                $taskMapper->save($task);
            }
        }

        foreach ($result as $key => $task) {
            $result[$key] = $task->run(false, true);
        }

        foreach ($taskMapper->searchOldInProgressTasks() as $task) {
            $task->setActive();
            $taskMapper->save($task);
        }

        $this->view->assign('result', $result);
        return $this->render('scheduler/runTask.tpl');
    }
}
?>