<?php

/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/user/userModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userModule.php 4368 2010-11-15 06:27:58Z iLobster $
 */

/**
 * userModule
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userModule extends simpleModule
{

    protected $icon = "sprite:sys/user";
    protected $classes = array('user', 'userFolder', 'userGroup', 'group', 'groupFolder', 'userAuth', 'userOnline', 'userRole', 'pamFacebook');
    protected $roles = array(
        'moderator',
        'user');
    protected $isSystem = true;

    public function getRoutes()
    {
        return array(
            array(
                'userLogin' => new requestRoute('user/:pam/:action', array(
                    'module' => 'user',
                    'pam' => 'simple'), array(
                    'pam' => '.*?',
                    'action' => '(?:login|logout)'))),
            array());
    }

}
?>