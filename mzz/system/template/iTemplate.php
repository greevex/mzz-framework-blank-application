<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/iTemplate.php $
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
 * @version $Id: iTemplate.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * Templates interface
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
interface iTemplate
{

    /**
     * Constructor
     *
     * @param view $view
     */
    public function __construct(view $view);

    /**
     * Render template
     *
     * @param string $resource template file name
     * @return mixed
     */
    public function render($resource);

}
?>
