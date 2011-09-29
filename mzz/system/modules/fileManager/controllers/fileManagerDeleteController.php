<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/fileManager/controllers/fileManagerDeleteController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: fileManagerDeleteController.php 3330 2009-06-05 07:55:55Z zerkms $
 */

/**
 * fileManagerDeleteController: контроллер для метода delete модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */

class fileManagerDeleteController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->getString('name');
        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return $this->forward404($fileMapper);
        }

        $fileMapper->delete($file);

        return jipTools::redirect();
    }
}

?>