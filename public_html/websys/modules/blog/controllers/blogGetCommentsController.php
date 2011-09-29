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
 * blogGetCommentsController
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogGetCommentsController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $blogMapper = $this->toolkit->getMapper('blog', 'blog');
        $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder');
        
        $post = $blogMapper->searchByKey($id);
        
        $comments = $commentsFolderMapper->searchFolder(get_class($post), $post->getId());
        
        if($comments) {
            
            return $this->render('blog/getComments.tpl');
        }
    }
}
?>