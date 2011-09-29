<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/menu/helpers/simpleMenuItemHelper.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: simpleMenuItemHelper.php 4171 2010-03-30 10:25:49Z desperado $
 */

fileLoader::load('menu/helpers/iMenuItemHelper');

/**
 * simpleMenuItemHelper: хелпер для simple меню
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */
class simpleMenuItemHelper implements iMenuItemHelper
{
    public function setArguments($item, array $args)
    {
        $item->setArguments(array());
        $item->setArgument('url', $args['url']);
        return $item;
    }

    public function injectItem($validator, $item = null, $view = null, array $args = null)
    {
        //$validator->rule('required', 'url', 'Укажите URL');
    }
}

?>