<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/cache/cacheMemory.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage cache
 * @version $Id: cacheMemory.php 3799 2009-10-13 05:39:04Z zerkms $
 */

/**
 * cacheMemory: драйвер кэширования в память
 *
 * @package system
 * @subpackage cache
 * @version 0.0.1
 */

class cacheMemory extends cacheBackend
{
    /**
     * Контейнер для данных
     *
     * @var arrayDataspace
     */
    private $data;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $this->flush();
    }

    public function set($key, $value, $expire = 0)
    {
        return $this->data->set($key, $value);
    }

    public function get($key)
    {
        return $this->data->get($key);
    }

    public function delete($key)
    {
        if ($this->data->has($key)) {
            return $this->data->delete($key);
        }

        return false;
    }

    public function flush($params = array())
    {
        $this->data = new arrayDataspace();
        return true;
    }
}

?>