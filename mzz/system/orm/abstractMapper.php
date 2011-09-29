<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/orm/abstractMapper.php $
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: abstractMapper.php 4387 2011-02-07 06:10:09Z striker $
 */

abstract class abstractMapper
{
    protected $map = array();

    public function getMap()
    {
        return $this->map;
    }
}
?>