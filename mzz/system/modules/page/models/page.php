<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/page/models/page.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: page.php 4250 2010-06-17 12:14:03Z bobr $
 */

/**
 * page: page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.4
 */
class page extends entity
{
    public function getFullPath()
    {
        $path = $this->getFolder()->getTreePath() . '/' . $this->getName();
        return substr($path, strpos($path, '/') + 1);
    }

}

?>