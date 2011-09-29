<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/filters/contentFilter.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: contentFilter.php 4436 2011-08-05 12:13:15Z bobr $
 */

fileLoader::load('core/loadDispatcher');
fileLoader::load('filters/aContentFilter');


/**
 * contentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @subpackage filters
 * @version 0.2.10
 */
class contentFilter extends abstractContentFilter implements iFilter
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
        // You can return cached content here, if necessary, instead rendering it again
        $output = $this->renderPage($response, $request);

        $response->append($output);
        $filter_chain->next();
    }

    /**
     * do changes in output after render page
     *
     * @param string $output
     */
    protected function afterRenderPage(&$output)
    {

    }

}

?>