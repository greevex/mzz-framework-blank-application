<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/fileManager/controllers/fileManagerDeleteFolderController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: fileManagerDeleteFolderController.php 3330 2009-06-05 07:55:55Z zerkms $
*/

/**
 * fileManagerDeleteFolderController: контроллер для метода deleteFolder модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerDeleteFolderController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->getString('name');

        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $folder = $folderMapper->searchByPath($name);

        if (!$folder) {
            return $this->forward404($folderMapper);
        }

        $folderMapper->delete($folder);

        return jipTools::redirect();
    }
}

?>