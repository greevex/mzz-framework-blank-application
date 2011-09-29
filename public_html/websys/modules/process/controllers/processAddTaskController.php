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
 * processAddTaskController
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processAddTaskController extends simpleController
{
    protected function getView()
    {
        $processTaskMapper = $this->toolkit->getMapper('process', 'processTask');

        $action = $this->request->getAction();

        $isEdit = strpos($action, 'edit') !== false;

        if ($isEdit) {
            $id = $this->request->getInteger('id');
            $processTask = $processTaskMapper->searchByKey($id);
            if (empty($processTask)) {
                return $this->forward404($processTaskMapper);
            }
        } else {
            $processTask = $processTaskMapper->create();
        }

        $validator = new formValidator();

        $validator->rule('length', 'processTask[command]', 'Field command is out of length', array(0, 255));
        $validator->rule('length', 'processTask[parameters]', 'Field parameters is out of length', array(0, 255));
        $validator->rule('length', 'processTask[method]', 'Field method is out of length', array(0, 10));
        $validator->rule('required', 'processTask[name]', 'Field name is required');
        $validator->rule('length', 'processTask[name]', 'Field name is out of length', array(0, 255));
        $validator->rule('numeric', 'processTask[parent_id]', 'Field parent_id is not numeric as expected');
        $validator->rule('range', 'processTask[parent_id]', 'Field parent_id is out of range', array(-2147483647, 2147483648));

        if ($validator->validate()) {
            $data = $this->request->getArray('processTask', SC_POST);

            $processTask->setName($data['name']);
            
            $processTaskMapper->save($processTask);

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
        $this->view->assign('processTask', $processTask);
        $this->view->assign('isEdit', $isEdit);

        return $this->render('process/addTask.tpl');
    }
}

?>