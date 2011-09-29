<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/news/newsModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: newsModule.php 4126 2010-03-10 07:42:15Z desperado $
 */

/**
 * newsModule
 *
 * @package modules
 * @subpackage news
 * @version 0.0.1
 */
class newsModule extends simpleModule
{
    protected $icon = "sprite:sys/news";
    
    protected $classes = array(
        'news',
        'newsFolder');

    protected $roles = array(
        'moderator',
        'user');

    public function getRoutes()
    {
        return array(
            array(),
            array(
                'newsFolder' => new requestRoute('news/:name/:action', array(
                    'module' => 'news',
                    'name' => 'root',
                    'action' => 'list'), array(
                    'name' => '.*?',
                    'action' => '(?:list|create|createFolder|editFolder|deleteFolder|moveFolder)'))));
    }
}

?>