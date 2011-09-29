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
 * schedulerCompletedTaskController
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerCompletedTaskController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $schedulerTaskMapper = $this->toolkit->getMapper('scheduler', 'schedulerTask');
        $task = $schedulerTaskMapper->searchByKey($id);

        if (!$task) {
            return $this->forward404($schedulerTaskMapper);
        }

        logMe("Finished task #{$task->getId()}");

        $task->setActive();
        if ($task->getTimesToRun() > 0) {
            if ((int)$task->getExecutionCount() + 1 >= (int)$task->getTimesToRun()) {
                $task->setCompleted();
                logMe("Task #{$task->getId()} executed {$task->getExecutionCount()} times of {$task->getTimesToRun()}. Changing to completed.");
            }
        }
        $task->setExecutionCount($task->getExecutionCount() + 1);
        $schedulerTaskMapper->save($task);

    }
}
?>