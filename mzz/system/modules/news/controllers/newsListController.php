<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/news/controllers/newsListController.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: newsListController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * newsListController: контроллер для метода list модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.2
 */
class newsListController extends simpleController
{
    protected function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $path = $this->request->getString('name');
        $newsFolder = $newsFolderMapper->searchByPath($path);

        if (empty($newsFolder)) {
            return $this->forward404($newsFolderMapper);
        }

        $newsMapper = $this->toolkit->getMapper('news', 'news');
        $this->setPager($newsMapper, 10, true);

        $this->view->assign('news', $newsFolder->getItems());
        $this->view->assign('folderPath', $newsFolder->getTreePath());
        $this->view->assign('rootFolder', $newsFolderMapper->searchByPath('root'));
        $this->view->assign('newsFolder', $newsFolder);

        return $this->render('news/list.tpl');
    }
}

?>