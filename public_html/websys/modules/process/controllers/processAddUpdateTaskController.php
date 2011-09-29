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
 * processAddUpdateTaskController
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processAddUpdateTaskController extends simpleController
{
    protected function getView()
    {
        $updateMapper = $this->toolkit->getMapper('update', 'update');
        $add_site = $this->request->getArray('add_site', SC_POST);
        $add_type = $this->request->getString('add_type', SC_POST);

        $validator = new formValidator();

        $validator->rule('required', 'parent_task', 'Укажите основное задание');
        $validator->rule('required', 'add_type', 'Укажите что нужно пролить');

        $taskMapper = $this->toolkit->getMapper('process', 'processTask');
        $task = $taskMapper->create();
        if ($validator->validate()) {
            $parent_task = $this->request->getInteger('parent_task', SC_POST);
            $post = $this->request->exportPost();
            unset($post['_csrf_token']);
            unset($post['parent_task']);
            unset($post['save_task']);
            $post = json_encode($post);
            $task->setParameters($post);
            $task->setCommand('/update/updateControl');
            $task->setMethod('post');
            $task->setName('Проливка');
            $task->setParentId($parent_task);
            $taskMapper->save($task);
            return jipTools::refresh();
        }



        $siteMapper = $this->toolkit->getMapper('site', 'site');
        $sites = $siteMapper->searchAll();

        $manufacturerMapper = $this->toolkit->getMapper('manufacturer', 'manufacturer');
        $criteria = new criteria;
        $criteria->orderByAsc('name');
        $manufacturers = $manufacturerMapper->searchAllByCriteria($criteria);

        $type_options = array(
            ''        => 'Выберите действие...',
            'remain'  => 'остатков',
            'retail'  => 'розничных цен',
        	'sort'    => 'сортировки',
        	'product'    => 'продуктов',
        	'photos'    => 'фотографий',
        	'uniserial'    => 'односерийных товаров',
        );

        $denied_sites = array(5, 7);
        $site_options = array(0 => 'Все сайты');
        foreach($sites as $site) {
            if(!in_array($site->getId(), $denied_sites))
            $site_options[$site->getId()] = "{$site->getName()} (db:{$site->getHost()})";
        }

        $manufacturer_select = array(0 => 'Все производители');
        foreach($manufacturers as $manufacturer) {
            $manufacturer_select[$manufacturer->getId()] = $manufacturer->getName();
        }

        $processTaskMapper = $this->toolkit->getMapper('process', 'processTask');
        $criteria = new criteria;
        $criteria->where('parent_id', null, criteria::IS_NULL);
        $tasks = $processTaskMapper->searchAllByCriteria($criteria);


        $this->view->assign('site_options', $site_options);
        $this->view->assign('tasks', $tasks);
        $this->view->assign('type_options', $type_options);
        $this->view->assign('validator', $validator);
        $this->view->assign('manufacturer_select', $manufacturer_select);

        $this->view->assign('rules', $updateMapper->create());


        $updateMapper = $this->toolkit->getMapper('update', 'update');
        $selected_manufacturers = $this->request->getArray('selected_manufacturers', SC_POST);

        return $this->render('process/addUpdateTask.tpl');
    }
}
?>