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
 * processAddReindexTaskController
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processAddReindexTaskController extends simpleController
{
    protected function getView()
    {
    	$go = $this->request->getInteger( 'go', SC_REQUEST );
    	$siteMapper = $this->toolkit->getMapper( 'site', 'site' );
    	$sites_tmp = $siteMapper->searchAllByField( 'production', 1 );
    	foreach ( $sites_tmp as $site )
    	{
    		$sites[ $site->getId() ] = $site->getName();
    	}

        $taskMapper = $this->toolkit->getMapper('process', 'processTask');
        $task = $taskMapper->create();
        if ($go) {
            $parent_task = $this->request->getInteger('parent_task', SC_POST);
            $post = $this->request->exportPost();
            unset($post['_csrf_token']);
            unset($post['parent_task']);
            $post = json_encode($post);
            $task->setParameters($post);
            $task->setCommand('/sort/reindex');
            $task->setMethod('post');
            $task->setName('Переиндексация');
            $task->setParentId($parent_task);
            $taskMapper->save($task);
            return jipTools::refresh();
        }

        $processTaskMapper = $this->toolkit->getMapper('process', 'processTask');
        $criteria = new criteria;
        $criteria->where('parent_id', null, criteria::IS_NULL);
        $tasks = $processTaskMapper->searchAllByCriteria($criteria);


        $this->view->assign('tasks', $tasks);
    	$this->view->assign( 'sites', $sites );
        return $this->render('process/addReindexTask.tpl');
    }
}
?>