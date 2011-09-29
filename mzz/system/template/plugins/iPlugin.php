<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/plugins/iPlugin.php $
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
 * @version $Id: iPlugin.php 4194 2010-04-07 06:44:41Z desperado $
*/

/**
 * Plugin interface
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
interface iPlugin
{
    public function __construct(view $view);
    public function run(array $params);
}
?>