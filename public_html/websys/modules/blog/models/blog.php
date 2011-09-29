<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/do.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: do.tpl 4004 2009-11-24 00:10:39Z mz $
 */

/**
 * blog
 * generated with mzz scaffolding
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blog extends entity
{
	public function getAuthor() {
		$userMapper = systemToolkit::getInstance()->getMapper('user', 'user');
		return $userMapper->searchOneByField('id', $this->getAuthorId());
	}
	
	public function getCommentsCount() {
		$commentsFolderMapper = systemToolkit::getInstance()->getMapper('comments', 'commentsFolder');
		$comments = $commentsFolderMapper->searchFolder(get_class($this), $this->getId());
        if(!$comments) {
            return "0";
        }
        return $comments->getCommentsCount();
	}
    
    public function getTags() {
        $blogTagsCompMapper = systemToolkit::getInstance()->getMapper('blog', 'tagsComp');
        $criteria = new criteria();
        $criteria->where('postId', $this->getId());
        $tags = $blogTagsCompMapper->searchAllByCriteria($criteria);
        if(!$tags) {
            $tt = "";
        } else {
            $tt = "";
            foreach($tags as $tag) {
                $tt .= $tag->getTag()->getTitle() . ",";
            }
        }
        return $tt;
    }
}
?>