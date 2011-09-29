<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/do.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: do.tpl 4004 2009-11-24 00:10:39Z mz $
 */

/**
 * processTask
 * generated with mzz scaffolding
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processTask extends entity
{
    public function getChildTasks()
    {
        if ($this->getParentId() > 0) {
            return array();
        }
        $criteria = new criteria();
        $criteria->where('parent_id', $this->getId());
        $criteria->orderByAsc('order');

        return $this->mapper->searchAllByCriteria($criteria);
    }
}
?>