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

/**
 * systemFeedbackController
 *
 * @package modules
 * @subpackage system
 * @version 0.0.1
 */
class systemFeedbackController extends simpleController
{
    protected function getView()
    {
        $this->view->disableMain();
        $respond = array('status' => false);
        $picture = $this->toolkit->getRequest()->getString('screenshot_image', SC_POST);
        $location = $this->toolkit->getRequest()->getString('location', SC_POST);
        
        if(!empty($picture)) {
            $description = $this->toolkit->getRequest()->getString('description', SC_POST);
            $path = "/generated/" . md5(microtime(true)) . ".png";
            $body = "";
            file_put_contents(systemConfig::$pathToWebRoot . $path, base64_decode(preg_replace('/^data:image\/(png|jpg);base64,/', "", $picture)));
            if(file_exists(systemConfig::$pathToWebRoot . $path)) {
                try {
                    $this->view->assign('imagefile', $_SERVER['HTTP_HOST'] . $path);
                    $this->view->assign('description', $description);
                    $this->view->assign('location', $location);
                    $this->view->assign('user', $this->toolkit->getUser());
                    $body = $this->view->render('system/feedback.tpl');
                    $respond['status'] = true;
                } catch(Exception $e) {
                    $respond['status'] = false;
                }
            }
        }
        if($respond['status']) {
            fileLoader::load('service/mailer/mailer');
            $mailer = mailer::factory();
            foreach(AppSystemConfig::$administrators as $administrator) {
                $mailer->set($administrator['email'],
                             $administrator['name'],
                             systemConfig::$mailer['default']['params']['smtp_user'],
                             systemConfig::$mailer['default']['params']['default_topic'],
                             'Пользователь сообщил об ошибке!',
                             $body);
                $mailer->send();
            }
        }
        return json_encode($respond);
    }
}
?>