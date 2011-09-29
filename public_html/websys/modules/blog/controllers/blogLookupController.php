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
 * blogLookupController
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogLookupController extends simpleController
{
    protected function getView()
    {
        $watchMapper = $this->toolkit->getMapper('blog', 'watch');
        $modules = $watchMapper->getEnabledModules();
        if(!$modules) {
            return;
        }
        foreach($modules as $m)
        {
            switch($m->getName()) {
                case "gallery":
                    $tm = explode('.', microtime(true));
                    if($m->getLastupdate() < microtime(true)-60*60*24) {
                        $photoMapper = $this->toolkit->getMapper('gallery', 'photo');
                        $criteria = new criteria;
                        $criteria->orderByDesc('id');
                        $photo = $photoMapper->searchOneByCriteria($criteria);
                        if($photo && $photo->getDate() > $m->getLastupdate()) {
                            $blogMapper = $this->toolkit->getMapper('blog', 'blog');
                            $post = $blogMapper->create();
                            $post->setTitle(date("d.m.Y") . " Обновления галереи");
                            $post->setAuthor(88);
                            $post->setDate(new sqlFunction('UNIX_TIMESTAMP'));
                            $post->setLookup(1);
                            $post->setModule($m->getName());
                            $blogMapper->save($post);
                        }
                        $m->setLastupdate($tm[0]);
                        $watchMapper->save($m);
                    }
                break;
            }
        }
    }
}
?>