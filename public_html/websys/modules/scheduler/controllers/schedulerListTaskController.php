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
 * schedulerListTaskController
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerListTaskController extends simpleController
{
    protected function getView()
    {
        $schedulerTaskMapper = $this->toolkit->getMapper('scheduler', 'schedulerTask');

        $this->setPager($schedulerTaskMapper);

        $all = $schedulerTaskMapper->searchAll();


        $processTaskMapper = $this->toolkit->getMapper('process', 'processTask');
        $tasks = $processTaskMapper->searchAllGroups();


        $this->view->assign('all', $all);
        $this->view->assign('tasks', $tasks);
        return $this->render('scheduler/listTask.tpl');
    }
}

?>