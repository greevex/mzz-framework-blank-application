<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/controllers/adminDevToolbarController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminDevToolbarController.php 4255 2010-06-21 10:02:06Z desperado $
 */

/**
 * adminDevToolbarController: контроллер для метода devToolbar модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
class adminDevToolbarController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        
        $denied = array(
                        'my-contact-list.ru',
                        'my-contact-list.com',
                        'www.my-contact-list.ru',
                        'www.my-contact-list.com',
                        );
        if(in_array($_SERVER['HTTP_HOST'], $denied)) {
            return $this->forward403($adminMapper);
        }

        $mods = $adminMapper->getModules();

        $hiddenClasses = array_flip(explode(',', $this->request->getString('mzz-devToolbarH', SC_COOKIE)));

        $this->view->assign('hiddenClasses', $hiddenClasses);

        $modules = array('app' => array(), 'sys' => array());
        
        foreach ($mods as $module) {
           if ($module->isSystem()) {
               $modules['sys'][$module->getName()] = $module;
           } else {
                $modules['app'][$module->getName()] = $module;
           }
        }

        ksort($modules['sys']);
        ksort($modules['app']);

         $this->view->assign('modules',  $modules);
        return $this->render('admin/devToolbar.tpl');
    }
}

?>
