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
 * blogListController
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogListController extends simpleController
{
    protected function getView()
    {
        $blogMapper = $this->toolkit->getMapper('blog', 'blog');
        $criteria = new criteria();
        $criteria->orderByDesc('id');
        $posts = $blogMapper->searchAllByCriteria($criteria);
        $tm = explode('.', time(true));
        if(!$posts) {
            $posts = array();
        } else {
            foreach($posts as $p) {
                if($p->getSticky() && $p->getStickyDate() < $tm[0]) {
                     $p->setSticky(0);
                     $blogMapper->save($p);
                }
            }
        }
        $newp = $blogMapper->create();
        $this->view->assign('posts', $posts);
        $this->view->assign('newp', $newp);
        return $this->render('blog/list.tpl');
    }
}
?>