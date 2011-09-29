<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * blogViewController
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogViewController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        if(isset($_REQUEST['onlyComments'])) {
            $onlyComments = (bool)$_REQUEST['onlyComments'];
        } else {
            $onlyComments = false;
        }
        $blogMapper = $this->toolkit->getMapper('blog', 'blog');
        $post = $blogMapper->searchOneByField('id', $id);
        if(!$post) {
            return $this->redirect404($blogMapper);
        }
        $this->view->assign('post', $post);
        if($onlyComments) {
            $this->view->disableMain();
            return $this->render('blog/onlyComments.tpl');
        }
        return $this->render('blog/view.tpl');
    }
}
?>