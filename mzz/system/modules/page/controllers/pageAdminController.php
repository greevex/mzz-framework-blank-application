<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/page/controllers/pageAdminController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: pageAdminController.php 4411 2011-06-26 14:59:29Z bobr $
*/

/**
 * pageAdminController: контроллер для метода admin модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.1
 */

class pageAdminController extends simpleController
{
    protected function getView()
    {
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $pageMapper = $this->toolkit->getMapper('page', 'page');

        $path = $this->request->getString('params');

        if (empty($path)) {
            $path = 'root';
        }

        $pageFolder = $pageFolderMapper->searchByPath($path);
        if (!$pageFolder) {
            if ($path == 'root') {
                $pageFolder = $pageFolderMapper->create();
                $pageFolder->setName('root');
                $pageFolder->setTitle('root');
                $pageFolderMapper->save($pageFolder);
            } else {
                return $this->forward404($pageFolderMapper);
            }
        }
        
        $breadCrumbs = $pageFolder->getTreeParentBranch();
        
        $locale = new fLocale(systemConfig::$i18n);
        $old_lang = $pageMapper->detach('i18n');
        $pages = $pageMapper->searchByFolder($pageFolder->getId());
        $pageMapper->plugins('i18n');

        $pager = $this->setPager($pageMapper);
        $this->view->assign('section_name', $this->request->getString('section_name'));
        $this->view->assign('pages', $pages);
        $this->view->assign('breadCrumbs', $breadCrumbs);
        $this->view->assign('pageFolder', $pageFolder);
        
        return $this->render('page/admin.tpl');
    }
}

?>