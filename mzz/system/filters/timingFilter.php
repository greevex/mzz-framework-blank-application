<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/filters/timingFilter.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: timingFilter.php 4171 2010-03-30 10:25:49Z desperado $
 */

/**
 * timingFilter: фильтр для подсчета времени выполнения скрипта
 *
 * @package system
 * @subpackage filters
 * @version 0.2
 */

//fileLoader::load('timer/timer');

class timingFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();
        $timer = $toolkit->getTimer();
        $view = $toolkit->getView('smarty');
        $view->assign('timer', $timer);

        $filter_chain->next();
    }
}

?>