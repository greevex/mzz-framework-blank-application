<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/drivers/smarty/plugins/modifier.date_i18n.php $
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
 * @version $Id: modifier.date_i18n.php 4375 2010-11-18 08:33:48Z iLobster $
*/

/**
 * smarty_modifier_date_i18n: модификатор для форматирования даты в соответствии с настройками часового пояса клиента

 * @param integer $date дата в unix timestamp или строковом представление
 * @param string $format формат даты
 * @return string отформатированная дата
 * @package system
 * @subpackage template
 * @version 0.2
 */
function smarty_modifier_date_i18n($date, $format = 'short_date_time', $rawFormat = false)
{
    if (!is_numeric($date)) {
        $timestamp = strtotime($date);
        if ($timestamp != 1) {
            $date = $timestamp;
        }
    }

    return i18n::date($date, $format, null, $rawFormat);
}

?>