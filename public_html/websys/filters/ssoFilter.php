<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/filters/userFilter.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage filters
 * @version $Id: userFilter.php 4376 2010-11-19 07:46:52Z iLobster $
 */
fileLoader::load('user/pam/pam');

/**
 * ssoFilter: filter for getting current user
 *
 * @package system
 * @subpackage filters
 * @version 0.1.2
 */
class ssoFilter implements iFilter
{
    /**
     * runs filter
     *
     * @param filterChain $filter_chain
     * @param httpResponse $response
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();
        $user = $toolkit->getUser();

        if (!$user->isLoggedIn()) {
            $pam = pam::factory('sso');
            $user = $pam->login();
            if ($user) {
                $toolkit->setUser($user);
            }
        }
        $filter_chain->next();
    }

}
?>