<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/service/md5PasswordHash.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: md5PasswordHash.php 2182 2007-11-30 04:41:35Z zerkms $
 */

fileLoader::load('service/passwordHash');

/**
 * md5PasswordHash: класс для хэширования пароля в md5
 *
 * @package system
 * @version 0.1
 */
class md5PasswordHash extends PasswordHash
{
    /**
     * Применение md5-хэширования
     *
     * @param string $value значение пароля
     * @return string результат применения md5-хэширования к $value
     */
    public function apply($value)
    {
        return md5($value);
    }
}
?>