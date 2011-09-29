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
 * schedulerDeleteTaskController
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerDeleteTaskController extends simpleController
{
    protected function getView()
    {
        $schedulerMapper = $this->toolkit->getMapper('scheduler', 'schedulerTask');

        $id = $this->request->getInteger('id');
        $task = $schedulerMapper->searchByKey($id);

        if (empty($task)) {
            return $this->forward404($schedulerMapper);
        }

        $schedulerMapper->delete($id);

        $url = new url('default2');
        $url->setModule('scheduler');
        $url->setAction('listScheduler');

        return jipTools::redirect($url->get());
    }
}
?>