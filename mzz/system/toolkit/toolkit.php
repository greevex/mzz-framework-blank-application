<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/toolkit/toolkit.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage toolkit
 * @version $Id: toolkit.php 2182 2007-11-30 04:41:35Z zerkms $
*/

fileLoader::load('toolkit/iToolkit');

/**
 * toolkit: абстрактный класс
 *
 * @package system
 * @subpackage toolkit
 * @version 0.1
 */
abstract class toolkit implements iToolkit
{
    /**
     * Методы Toolkit-ов
     *
     * @var array
     */
    private $tools = array();

    /**
     * Конструктор. Сохраняет методы Toolkit-а
     *
     */
    public function __construct()
    {
        $toolkitMethods = get_class_methods($this);
        foreach ($toolkitMethods as $value) {
            if (!method_exists('toolkit', $value)) {
                $this->tools[strtolower($value)] = true;
            }
        }
    }

    /**
     * Возвращает данный toolkit если в нем содержится метод $toolName
     *
     * @param string $toolName
     * @return object|false
     */
    final public function getToolkit($toolName)
    {
        return isset($this->tools[strtolower($toolName)]) ? $this : false;
    }
}
?>