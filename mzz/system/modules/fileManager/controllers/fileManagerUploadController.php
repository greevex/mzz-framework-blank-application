<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/fileManager/controllers/fileManagerUploadController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: fileManagerUploadController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * fileManagerUploadController: контроллер для метода upload модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.4
 */
class fileManagerUploadController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $path = $this->request->getString('name');

        $folder = $folderMapper->searchByPath($path);

        if (!$folder) {
            return $this->forward404($folderMapper);
        }

        $validator = new formValidator();
        $validator->rule('uploaded', 'file', 'Укажите файл для загрузки');
        $validator->rule('filesize', 'file', 'Превышен размер', $folder);

        if ($exts = $folder->getExts()) {
            $exts = explode(';', $exts);
        } else {
            $exts = array();
        }
        
        $validator->rule('fileext', 'file', 'Неверное расширение!', $exts);
        $validator->rule('regex', 'name', 'Недопустимые символы в имени', '/^[a-zа-я0-9_\.\-! ]+$/ui');

        $errors = $validator->getErrors();
        $success = false;
        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $header = $this->request->getString('header', SC_POST);
            $about = $this->request->getString('about', SC_POST);
            $direct_link = $this->request->getString('direct_link', SC_POST);

            try {
                $file = $folder->upload('file', $name);
                $file->setRightHeader($header);
                $file->setAbout($about);
                $file->setDirectLink($direct_link);

                $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
                $fileMapper->save($file);

                $this->view->assign('file_name', $file->getName());
                $success = true;
                $messages = array();
            } catch (mzzRuntimeException $e) {
                $errors->set('file', $e->getMessage());
            }
        }

        $url = new url('withAnyParam');
        $url->setAction('upload');
        $url->add('name', $folder->getTreePath());

        $this->view->assign('form_action', $url->get());
        $this->view->assign('validator', $validator);

        $this->view->assign('success', $success);
        $this->view->assign('messages', isset($messages) ? $messages : $validator->getErrors());

        $this->view->assign('folder', $folder);

        return $this->render('fileManager/upload.tpl');
    }
}

?>
