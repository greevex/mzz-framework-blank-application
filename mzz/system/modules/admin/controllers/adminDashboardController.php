<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/controllers/adminDashboardController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminDashboardController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * adminDashboardController
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminDashboardController extends simpleController
{
    protected function getView()
    {
        return $this->render('admin/dashboard.tpl');
    }
}

?>