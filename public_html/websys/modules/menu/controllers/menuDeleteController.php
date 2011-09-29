<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/menu/controllers/menuDeleteController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: menuDeleteController.php 3388 2009-06-20 12:26:10Z striker $
 */

/**
 * menuDeleteController: контроллер для метода delete модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuDeleteController extends simpleController
{
    protected function getView()
    {
        $itemMapper = $this->toolkit->getMapper('menu', 'menuItem');
        $id = $this->request->getInteger('id');

        $item = $itemMapper->searchByKey($id);

        if ($item) {
            $itemMapper->delete($item);
        }

        return jipTools::redirect();
    }
}
?>