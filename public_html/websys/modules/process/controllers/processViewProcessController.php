<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/controller.view.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.view.tpl 4201 2010-04-12 11:27:49Z desperado $
 */

/**
 * processViewProcessController
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processViewProcessController extends simpleController
{
    protected function getView()
    {
        $processMapper = $this->toolkit->getMapper('process', 'process');

        $id = $this->request->getInteger('id');
        $process = $processMapper->searchByKey($id);

        if (empty($process)) {
            return $this->forward404($processMapper);
        }

        $this->view->assign('process', $process);

        return $this->render('process/viewProcess.tpl');
    }
}

?>