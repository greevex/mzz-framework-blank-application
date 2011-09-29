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

fileLoader::load('deleter/mappers/IDeleteRelation');

/**
 * deleterDeleteController
 *
 * @package modules
 * @subpackage deleter
 * @version 0.0.1
 */
class deleterDeleteController extends simpleController
{
    protected function getView()
    {
        $module = $this->request->getString("module_name");
        $class = $this->request->getString("class");
        $field = $this->request->getString("field");
        $value = $this->request->getString("value");
        $action = $this->request->getString("original_action");
        $session = $this->toolkit->getSession();
        $confirmCode = $this->request->getString("confirm", SC_REQUEST);

        $className = $this->request->getString('className', SC_REQUEST);

        try {
             $mapper = $this->toolkit->getMapper($module, $class);
             if ($className && method_exists($mapper, 'setClassName')) {
                 $mapper->setClassName($className);
             }
        } catch (Exception $e) {
            return $this->forward404();
        }

        $this->view->assign('module', $module);
        $this->view->assign('class', $class);
        $this->view->assign('field', $field);
        $this->view->assign('value', $value);

        if (empty($confirmCode) || $confirmCode != $session->get('confirm_code')) {
             $session = $this->toolkit->getSession();
             $session->set('confirm_code', $code = md5(microtime()));
             $url = $this->request->getRequestUrl();
             $url = $url . (strpos($url, '?') ? '&' : '?') . '_confirm=' . $code;
             $this->view->assign('url', $url);
             $this->view->assign('confirm_code', $code);
             $view = $this->render('deleter/delete.tpl');

        } else {
            $type = $this->request->getInteger('deletion_type', SC_REQUEST);
            $type = $this->request->getInteger('deletion_type', SC_REQUEST);


            $object = $mapper->searchOneByField($field, $value);
            if (!$object) {
                return $this->forward404($mapper);
            }
            if (!$object->canRun($action)) {
                return $this->forward403($mapper);
            }

            /**
            $mapper->delete($object);
            return jipTools::refresh();*/


            if ($type === deleteionTypes::ONLY_OBJECT || $type === deleteionTypes::OBJECT_AND_RELATIONS) {
                $mapper->delete($object);
            }

            if ($type === deleteionTypes::ONLY_RELATIONS || $type === deleteionTypes::OBJECT_AND_RELATIONS) {
                $map = $mapper->map();
                $relations = array_merge(
                    $mapper->getRelations()->oneToOne(),
                    $mapper->getRelations()->oneToMany(),
                    $mapper->getRelations()->manyToMany());
                foreach($relations as $key => $relation) {
                    $this->deleteObject($object, $map, $key);
                }

                if ($mapper instanceof IDeleteRelation || is_callable(array($mapper, 'deleteRelation'))) {
                    $mapper->deleteRelation($object);
                    unset($object);
                }
            }

            return jipTools::refresh();
        }
        return $view;

    }

    private function deleteObject($object, $map, $field)
    {
        // do not delete relations by primary key
        if (!isset($map[$field]['foreign_key']) || $map[$field]['foreign_key'] == 'id') {
            return false;
        }
        $rel_mapper_array = explode('/', $map[$field]['mapper']);
        $rel_mapper = $this->toolkit->getMapper($rel_mapper_array[0], $rel_mapper_array[1]);

        if (method_exists($object, 'getClassName') && method_exists($object, 'setClassName')) {
            $rel_mapper->setClassName($object->getClassName());
        }
        $rel_objects = call_user_func(array($object,$map[$field]['accessor']));
        if ($rel_objects) {
            if (!($rel_objects instanceof collection)) {
                $rel_objects = array($rel_objects);
            }
            foreach ($rel_objects as $rel_object) {
                $rel_mapper->delete($rel_object);
            }
            unset($rel_object);
        }
    }
}

class deleteionTypes
{
    const ONLY_OBJECT = 1;
    const ONLY_RELATIONS = 2;
    const OBJECT_AND_RELATIONS = 3;
}
?>