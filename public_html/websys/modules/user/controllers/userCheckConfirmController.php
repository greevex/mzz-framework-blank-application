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
 * userCheckConfirmController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userCheckConfirmController extends simpleController
{
    protected function getView()
    {
		$userMapper = $this->toolkit->getMapper('user', 'user');
		$criteria = new criteria;
		$criteria->where('confirmed', null, criteria::NOT_EQUAL);
		$users = $userMapper->searchAllByCriteria($criteria);
		if(!$users) {
			return $this->render('user/noUsers.tpl');	
		}
		fileLoader::load('service/mailer/mailer');
		foreach ( $users as $user ) {
			$this->view->assign('confirm', $user->getConfirmed());
			$this->view->assign('user', $user->getLogin());
			$body = $this->render('user/register/mailbody.tpl');

			$mailer = mailer::factory();

			$mailer->set($user->getEmail(), $user->getLogin(), 'ostrovsky@svetex.ru', 'ElMarket!', 'Registration confirmation', $body);
			$mailer->send();
			unset($mailer);
		}
		$this->view->assign('users', $users);
		return $this->render('user/checkConfirm.tpl');
    }
}
?>