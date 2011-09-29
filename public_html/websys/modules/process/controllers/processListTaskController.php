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
 * processListTaskController
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processListTaskController extends simpleController
{
    protected function getView()
    {
        $processTaskMapper = $this->toolkit->getMapper('process', 'processTask');

        $this->setPager($processTaskMapper);

        $all = $processTaskMapper->searchAllGroups();
        $task = $processTaskMapper->create();

        $available_parents = array();
        foreach ($all as $process) {
            if ($process->getParentId() < 1) {
                $available_parents[$process->getId()] = $process->getName();
            }
        }

        $validator = new formValidator();
        if ($validator->validate() && $task->canRun('addTask')) {
            $tasks = $this->request->getArray('task', SC_POST);

            foreach ($tasks as $id => $task_params) {
                $task_entity = $processTaskMapper->searchByKey($id);
                $task_entity->setParentId($task_params['parent_id']);
                $task_entity->setOrder($task_params['order']);
                $processTaskMapper->save($task_entity);
            }
        }

        $this->view->assign('all', $all);
        $this->view->assign('available_parents', $available_parents);
        return $this->render('process/listTask.tpl');
    }
}

?>