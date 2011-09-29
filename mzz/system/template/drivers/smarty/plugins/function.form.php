<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/drivers/smarty/plugins/function.form.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: function.form.php 4302 2010-09-07 05:09:27Z iLobster $
*/

/**
 * smarty_function_form: алиас для вызова form::open
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_function_form($params, $smarty)
{
    return $smarty->getRegisteredObject('form')->open($params, $smarty);
}

?>
