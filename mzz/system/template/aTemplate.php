<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/aTemplate.php $
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
 * @version $Id: aTemplate.php 4197 2010-04-12 06:22:25Z desperado $
*/

fileLoader::load('template/iTemplate');

/**
 * Abstract template class
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
abstract class aTemplate implements iTemplate
{
    /**
     * @var view
     */
    protected $view = null;

    public function __construct(view $view)
    {
        $this->view = $view;
    }

    public function view()
    {
        return $this->view;
    }
}
?>
