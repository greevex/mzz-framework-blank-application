<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * privateMessageViewController
 *
 * @package modules
 * @subpackage privateMessage
 * @version 0.0.1
 */
class privateMessageViewController extends simpleController
{
    protected function getView()
    {
        $criteria = new criteria;
        $criterion = new criterion('id', MZZ_USER_GUEST_ID, criteria::NOT_EQUAL);
        $criterion->addAnd(new criterion('name', '', criteria::NOT_EQUAL));
        $criteria->where($criterion);
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $users = $userMapper->searchAllByCriteria($criteria);
        $this->view->assign('contacts', $users);
        return $this->render('privateMessage/view.tpl');
    }
}
?>