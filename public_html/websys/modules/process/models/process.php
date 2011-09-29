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
 * process
 * generated with mzz scaffolding
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class process extends entity
{
    
    public function getUser()
    {
        return systemToolkit::getInstance()->getMapper( 'user', 'user' )->searchOneByField( 'id', $this->getUserId() );
    }
    
}
?>