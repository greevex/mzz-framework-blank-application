<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

fileLoader::load('user/pam/pam');

/**
 * userUserSsoLoginController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userUserSsoLoginController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();
        if (!$user->isLoggedIn()) {
            $pam = pam::factory('sso');
            $user = $pam->login();
            if (!$user) {
                $result = 'Wrong token or login or password';
            } else {
                $this->toolkit->setUser($user);
                $result = 'ok';
            }
        }
        $result = 'ok';
        return json_encode(array('result' => $result));
    }
}
?>