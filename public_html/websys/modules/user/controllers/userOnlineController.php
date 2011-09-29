<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/user/controllers/userOnlineController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userOnlineController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * userOnlineController: контроллер для метода online модуля user
 *
 * @package modules
 * @subpackage user
 * @author greevex
 * @version 1.0
 */

class userOnlineController extends simpleController
{
    protected function getView()
    {
        $userOnlineMapper = $this->toolkit->getMapper('user', 'userOnline');

        $this->toolkit->getUser()->checkOnline();
        

        // Counts
        $allusers = $userOnlineMapper->checkTimeout();
        $guests = 0;
        $registered = 0;
        foreach($allusers as $u) {
            if($u->getUser()->getId() == MZZ_USER_GUEST_ID) {
                $guests++;
            } else {
                $registered++;
            }
        }

        $this->view->assign('registered', $registered);
        $this->view->assign('guests', $guests);
        $this->view->assign('users', $allusers);
        return $this->render('user/usersOnline.tpl');
    }
}

?>