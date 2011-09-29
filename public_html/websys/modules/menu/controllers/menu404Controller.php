<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/menu/controllers/menu404Controller.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: menu404Controller.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * menu404Controller: контроллер для метода 404 модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menu404Controller extends simpleController
{
    protected function getView()
    {
        return $this->render('menu/notfound.tpl');
    }
}

?>