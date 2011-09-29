<?php

/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/drivers/smarty/plugins/modifier.crud_property.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id: modifier.crud_property.php 4163 2010-03-26 10:30:36Z mz $
*/

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_crud_property($name, $property)
{
    $modifier = '';
    if (isset($property['type']) && $property['type'] == 'char') {
        $modifier = 'h';
    }

    return '{$' . $name . '->' . $property['accessor'] . '()' . ($modifier ? '|' . $modifier : '') . '}';
}

?>