<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/controller.list.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.list.tpl 4201 2010-04-12 11:27:49Z desperado $
 */

/**
 * blogListModulesController
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogListModulesController extends simpleController
{
    protected function getView()
    {
        $watchMapper = $this->toolkit->getMapper('blog', 'watch');

        $this->setPager($watchMapper);

        $all = $watchMapper->searchAll();

        $this->view->assign('all', $all);
        return $this->render('blog/listModules.tpl');
    }
}

?>