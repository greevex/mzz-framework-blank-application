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
 * schedulerSaveTaskController
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerSaveTaskController extends simpleController
{
    protected function getView()
    {
        $schedulerTaskMapper = $this->toolkit->getMapper('scheduler', 'schedulerTask');
        $data = $this->request->getArray('schedulerTask', SC_POST);

        $action = $this->request->getAction();

        $processTaskMapper = $this->toolkit->getMapper('process', 'processTask');
        $tasks = $processTaskMapper->searchAllGroups();

        $isEdit = strpos($action, 'edit') !== false;

        if ($isEdit) {
            $id = $this->request->getInteger('id');
            $schedulerTask = $schedulerTaskMapper->searchByKey($id);
            if (empty($schedulerTask)) {
                return $this->forward404($schedulerTaskMapper);
            }
        } else {
            $schedulerTask = $schedulerTaskMapper->create();
        }

        $validator = new formValidator();


        $validator->rule('required', 'schedulerTask[command]', 'Field command is required');
        $validator->rule('length', 'schedulerTask[command]', 'Field command is out of length', array(0, 255));

        $validator->rule('numeric', 'schedulerTask[times_to_run]', 'Field times_to_run is not numeric as expected');
        $validator->rule('range', 'schedulerTask[times_to_run]', 'Field times_to_run is out of range', array(0, 4294967296));

        $validator->rule('required', 'schedulerTask[method]', 'Field method is required');
        $validator->rule('length', 'schedulerTask[method]', 'Field method is out of length', array(0, 10));

        if ($validator->validate()) {
            if (!empty($data['start_date'])) {
                $start_date = new DateTime($data['start_date']);
                $start_date =  $start_date->format('Y/m/d');
                $schedulerTask->setStartDate($start_date);
            } else {
                $schedulerTask->setStartDate(null);
            }
            $schedulerTask->setStatus(1);

            $schedulerTask->setCommand($data['command']);
            if (!$isEdit) {
                $schedulerTask->setType($data['type']);
            }
            if (!empty($data['start_time'])) {
                $schedulerTask->setStartTime($data['start_time']);
            }

            $parameters = array();
            if (is_array($data['parameters']['name'])) {
                foreach ($data['parameters']['name'] as $key => $param) {
                    if (empty($param)) {
                        continue;
                    }
                    $parameters[$param] = $data['parameters']['value'][$key];
                }
            }

            if ($isEdit) {
                $schedulerTask->setParameters($data['parameters']);
            } else {
                $schedulerTask->setParameters(json_encode($parameters));
            }


            $schedulerTask->setTimesToRun($data['times_to_run']);
            $schedulerTask->setInterval($data['interval']);
            $schedulerTask->setMethod($data['method']);

            $schedulerTaskMapper->save($schedulerTask);

            $url = new url('default2');
            $url->setModule('scheduler');
            $url->setAction('listTask');
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
        $this->view->assign('schedulerTask', $schedulerTask);
        $this->view->assign('isEdit', $isEdit);
        $this->view->assign('tasks', $tasks);

        return $this->render('scheduler/saveTask.tpl');
    }
}

?>