<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/captcha/captchaModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: captchaModule.php 4358 2010-11-10 09:12:58Z iLobster $
 */

/**
 * captchaModule
 *
 * @package modules
 * @subpackage captcha
 * @version 0.0.1
 */
class captchaModule extends simpleModule
{

    protected $classes = array(
        'captcha');

    public function getRoutes()
    {
        return array(
            array(),
            array(
                'captcha' => new requestRoute('captcha', array(
                    'module' => 'captcha',
                    'action' => 'view'))));
    }

    protected $isSystem = true;

}
?>