<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/comments/controllers/commentsEditController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsEditController.php 4197 2010-04-12 06:22:25Z desperado $
*/

fileLoader::load('forms/validators/formValidator');

/**
 * commentsEditController: контроллер для метода post модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.2
 */

class commentsEditController extends simpleController
{
    protected function getView()
    {
        $commentsMapper = $this->toolkit->getMapper('comments', 'comments');
        $id = $this->request->getInteger('id');

        $comment = $commentsMapper->searchById($id);
        if (!$comment) {
            return $this->forward404($commentsMapper);
        }

        $validator = new formValidator();
        $validator->rule('required', 'text', 'Введите комментарий');

        if ($validator->validate()) {
            $text = $this->request->getString('text', SC_POST);

            $comment->setText($text);
            $commentsMapper->save($comment);

            return jipTools::redirect();
        }

        $url = new url('withId');
        $url->setAction('edit');
        $url->add('id', $comment->getId());

        $this->view->assign('comment', $comment);
        $this->view->assign('validator', $validator);
        $this->view->assign('form_action', $url->get());

        return $this->render('comments/edit.tpl');
    }
}
?>