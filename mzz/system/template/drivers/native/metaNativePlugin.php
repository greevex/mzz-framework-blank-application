<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/drivers/native/metaNativePlugin.php $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: metaNativePlugin.php 4220 2010-05-13 04:23:19Z striker $
 */

/**
 * Native meta plugin
 *
 * @package system
 * @subpackage template
 * @version 0.0.1
 */
class metaNativePlugin extends aNativePlugin
{
    public function run(Array $params = array())
    {
        return $this->view->plugin('meta', $params);
    }
}
?>