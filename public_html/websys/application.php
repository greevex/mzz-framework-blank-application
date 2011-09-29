<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/apps/demo/trunk/application.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage core
 * @version $Id: application.php 3783 2009-10-09 11:02:50Z zerkms $
*/

/**
* Require user functions
*/
require systemConfig::$pathToApplication . "/service/userFunctions.php";

/**
 * application
 *
 * @package system
 * @subpackage application
 * @version 0.1
 */
class application extends core
{
    protected function composeFilters($filter_chain)
    {
        fileLoader::load('filters/ssoFilter');
        $filter_chain->registerFilter(new timingFilter());
        $filter_chain->registerFilter(new sessionFilter());
        $filter_chain->registerFilter(new routingFilter());
        $filter_chain->registerFilter(new userFilter());
        $filter_chain->registerFilter(new userPreferencesFilter());
        $filter_chain->registerFilter(new ssoFilter());
        $filter_chain->registerFilter(new contentFilter());
        return $filter_chain;
    }

    protected function composeToolkit()
    {
        fileLoader::load('toolkit/appToolkit');
        $this->toolkit = systemToolkit::getInstance();
        $this->toolkit->addToolkit(new appToolkit());
    }


}

?>