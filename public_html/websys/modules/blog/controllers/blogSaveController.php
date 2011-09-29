<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * blogSaveController
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogSaveController extends simpleController
{
    protected function getView()
    {
        $act = $this->request->getAction();
        $id = $this->request->getInteger('id');
        $data = $this->request->getArray('post', SC_POST);
		$blogMapper = $this->toolkit->getMapper('blog', 'blog');
		$tagsMapper = $this->toolkit->getMapper('blog', 'tags');
		$tagsCompMapper = $this->toolkit->getMapper('blog', 'tagsComp');
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $mods = $adminMapper->getModules();
        $modules = array('' => 'Выберите модуль');
        foreach($mods as $mod) {
            $modules[$mod->getName()] = $mod->getName();
        }

        if($act == 'edit') {
            $edit = true;
        } else {
            $edit = false;
        }

        if($edit) {
            $post = $blogMapper->searchOneByField('id', $id);
        } else {
            $post = $blogMapper->create();
        }

		$validator = new formValidator();
		$validator->rule('required', 'post[title]', 'Название записи обязательно!');
        if(isset($data['lookup']) && $data['lookup']==1) {
            $validator->rule('required', 'post[module]', 'Модуль должен быть выбран!');
        } else {
            $validator->rule('required', 'post[content]', 'Текст записи обязателен!');
        }

        if(isset($data['sticky']) && $data['sticky']==1) {
            $validator->rule('required', 'post[stickydate]', 'Укажите дату окончания!');
        } else {
            $data['sticky'] = 0;
        }

		if($validator->validate()) {
			$post->setTitle($data['title']);
			$post->setContent($data['content']);
            $post->setLookup($data['lookup']);
            $post->setModule($data['module']);
			if(!$edit) {
                $post->setAuthor($this->toolkit->getUser()->getId());
			    $post->setDate(new sqlFunction('UNIX_TIMESTAMP'));
            }
            $post->setSticky($data['sticky']);
            $post->setStickyDate(strtotime($data['stickydate']));
			$blogMapper->save($post);

			$tags = explode(',', $data['tags']);
			foreach($tags as $tag) {
				if(!empty($tag)) {
					$t = $tagsMapper->searchOneByField('title', $tag);
					if(!$t) {
						$t = $tagsMapper->create();
						$t->setTitle($tag);
						$t->setCount((int)1);
					} else {
						$t->setCount($t->getCount() + 1);
					}
					$tagsMapper->save($t);
					$nt = $tagsCompMapper->create();
					$nt->setPostId($post->getId());
					$nt->setTagId($t->getId());
					$tagsCompMapper->save($nt);
				}
			}
			$url = new url('default2');
			$url->setModule('blog');
            $url->setAction('list');
			return jipTools::redirect($url->get());
		}

		$url = new url('withId');
		$url->setModule('blog');
		$url->setAction($edit ? 'edit' : 'save');
        $url->add('id', $id);

        if($edit) {
            $url->add('id', $id);
            $this->view->assign('lookup', $post->getLookup());
            $this->view->assign('sticky', $post->getSticky());
            $this->view->assign('title', $post->getTitle());
            $this->view->assign('content', $post->getContent());
            $this->view->assign('module', $post->getModule());
            //$this->view->assign('tags', $post->getTags());
        }
        $this->view->assign('post', $post);
		$action = $url->get();
		$this->view->assign('action', $action);
        $this->view->assign('validator', $validator);
		$this->view->assign('modules', $modules);
        return $this->render('blog/save.tpl');
    }
}
?>