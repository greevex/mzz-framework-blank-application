<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/drivers/smarty/IfSmarty.php $
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
 * @version $Id: IfSmarty.php 4168 2010-03-30 07:34:55Z desperado $
*/

/**
 * IFramySmarty: модификация Smarty для работы с шаблонами
 *
 * @version 0.5
 * @package system
 * @subpackage template
 */
interface IfSmarty
{
    /**
     * конструктор
     *
     * @param object $smarty
     */
    function __construct(smartyTemplate $smarty);

    /**
     * Выполняет шаблон и возвращает результат
     * Декорирован для реализации вложенных шаблонов.
     *
     * @param string $resource
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    function fetch($resource, $cache_id = null, $compile_id = null, $display = false);

    /**
     * Получает и возвращает относительный путь к исходнику шаблонов.
     * Если нужный шаблон находится в корне папки с шаблонами, то изменений нет,
     * если в корне нет, то к относительному путю прибавляется первая часть имени до точки.
     *
     * Пример:
     * <code>
     * news.view.tpl -> news/news.view.tpl
     * main.tpl -> main.tpl
     * </code>
     *
     * @param string $name
     * @param object $smarty
     * @return string
     */
    //function getResourceFileName($name);

    /**
     * Возвращает директорию с исходниками шаблонов
     *
     * @return string абсолютный путь
     */
    public function getTemplateDir();

}

?>