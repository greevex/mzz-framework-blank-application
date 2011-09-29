<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/drivers/native/aNativePlugin.php $
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
 * @version $Id: aNativePlugin.php 4194 2010-04-07 06:44:41Z desperado $
 */

fileLoader::load('template/drivers/native/iNativePlugin');

/**
 * Native abstract plugin
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
abstract class aNativePlugin implements iNativePlugin
{
    /**
     * @var nativeTemplate
     */
    protected $native;

    /**
     * @var view
     */
    protected $view;

    /**
     * Constructor
     * @param nativeTemplate $native
     * @param view $view
     */
    public function __construct(nativeTemplate $native, view $view)
    {
        $this->native = $native;
        $this->view = $view;
    }

    /**
     * Plugins magic goes here
     */
    public function run(){}
}
?>