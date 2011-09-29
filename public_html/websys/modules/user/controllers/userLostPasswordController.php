<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Platform (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * userLostPasswordController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 * @author GreeveX
 */
class userLostPasswordController extends simpleController
{
    protected function getView()
    {
        $email = $this->request->getString('email', SC_GET);
        $rte = $this->request->getString('rte', SC_GET);
        $etoken = $this->request->getString('etoken', SC_GET);
        
        $e = false;
        $sended = false;
        $notfound = true;
        $good = false;
        
		$userMapper = $this->toolkit->getMapper('user', 'user');
        
        if(!empty($email))
        {
            $notfound = false;
			$user = $userMapper->searchOneByField('email', $email);
	        $e = true;
	        if(!$user) {
		        $notfound = true;
	        } else {
		        $etoken = substr(md5($user->getLogin() . date("d.m.Y")), 0, 8) . time();
		        $url = new url('default2');
		        $url->setModule('user');
		        $url->setAction('lostPassword');
		        $body = "<html><head><title>Password rerteiving</title></head><body>
					        Здравствуйте, на Ваш e-mail было запрошено восстановление пароля.<br />
					        Если вы об этом ничего не знаете, просто проигнорируейте данное письмо.<br />
					        Для продолжения операции восстановления пароля кликните на ссылку ниже.<br />
					        Ссылка действительна в течении текущего дня (сегодня " . date("d-m-Y") . ").<br />
					        <a href=\"{$url->get()}?rte={$user->getEmail()}&etoken={$etoken}\">{$url->get()}?rte={$user->getEmail()}&etoken={$etoken}</a><br />
					        ----------------<br />
					        Hello, your email was used for password retreiving.<br />
					        If you don't know anything about it, please ignore and delete this message.<br />
					        To accept password retreiving click link below.<br />
					        This link would work today only (" . date("d-m-Y") . ").<br />
					        <a href=\"{$url->get()}?rte={$user->getEmail()}&etoken={$etoken}\">{$url->get()}?rte={$user->getEmail()}&etoken={$etoken}</a>
				        </body></html>";
		        
		        fileLoader::load('service/mailer/mailer');
                $mailer = mailer::factory();
		        $mailer->set(
					         $user->getEmail(),
					         $user->getLogin(),
					         systemConfig::$mailer['default']['params']['smtp_user'],
                             systemConfig::$mailer['default']['params']['default_topic'],
					         'Password retreiving',
					         $body
					         );
                $mailer->isHTML = true;
                $mailer->send();
		        $sended = true;
		        $etoken = null;
	        }
        } elseif(!empty($rte) && !empty($etoken)) {
            
			$user = $userMapper->searchOneByField('email', $rte);
			if(!$user) {
		        $notfound = true;
			} else {
                $notfound = false;
				$etoken = substr(md5($user->getLogin() . date("d.m.Y")), 0, 8) . time();
				if(substr($etoken, 0, 8) == substr(md5($user->getLogin() . date("d.m.Y")), 0, 8)) {
					$newpassword = strrev(substr($etoken, 0, 8));
					$user->setPassword($newpassword);
					$userMapper->save($user);
					$body = "Ваши новые данные для входа на сайт:<br />
								Login: {$user->getLogin()}<br />
								Password: {$newpassword}<br />
								<hr />
								Your login and new password:<br />
								Login: {$user->getLogin()}<br />
								Password: {$newpassword}";
					
					fileLoader::load('service/mailer/mailer');
					$mailer = mailer::factory();
                    $mailer->set(
                                 $user->getEmail(),
                                 $user->getLogin(),
                                 systemConfig::$mailer['default']['params']['smtp_user'],
                                 systemConfig::$mailer['default']['params']['default_topic'],
                                 'Password retreiving',
                                 $body
                                 );
					$mailer->isHTML = true;
					$mailer->send();
					$good = true;           
				}
			}
        }
        $this->view->assign('good', $good);
        $this->view->assign('sended', $sended);
        if(isset($user)) $this->view->assign('user', $user);
        $this->view->assign('e', $e);
        $this->view->assign('notfound', $notfound);
        return $this->render('user/lostPassword.tpl');
    }
}
?>