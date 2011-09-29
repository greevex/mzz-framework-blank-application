<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/controller.list.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.list.tpl 4201 2010-04-12 11:27:49Z desperado $
 */

fileLoader::Load("report/controllers/xlsGenerateController");
/**
 * userListPermissionController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userListPermissionController extends simpleController
{
    protected function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');

        $all = $userMapper->searchAll();
        $access_to = array();

        foreach ($all as $key => $user) {
            $result = $this->getUserAccess($user);

            $access_to[$user->getId()] = $result[0];
            $all_actions = $result[1];
            //list($access_to[$user->getId()], $all_actions) = $this->getUserAccess($user);
        }


        $xls = new xlsGenerateController("Права доступа", "Таблица прав доступа к мегацентру");

        $titles = array(
            'ID',
            'Имя',
            'Логин',
            'Группы'
        );
        foreach ($all_actions as $module => $module_actions) {
            foreach ($module_actions as $domain => $domain_actions) {
                foreach ($domain_actions as $action_name => $action) {
                    $titles[] = "{$domain} - " .  (isset($action['title']) ? $action['title'] . '-' : '') . $action_name;
                }
            }
        }
        $letter = 'E';
        for ($i = 4, $total = count($titles); $i < $total; $i++) {
            $titles['params']['width'][$letter++] = strlen($titles[$i]);
        }

        $titles['params']['width'] = array_merge(array(
            'A' => 10,
            'B' => 40,
            'C' => 20,
            'D' => 20
        ), $titles['params']['width']);


        $styleRow = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'borders' => array(
                    'allborders' => array(
                        'color' => array('rgb' => '000000'),
                    ),
                ),
        );

        $xls->addTitles($titles);

        $row = 1;

        foreach ($all as $user) {
            $row++;
            $values = array();
            $groups = '';
            $height = 10;
            $group_num = 1;
            foreach ($user->getGroups() as $group) {
                $groups .= ($group_num++) . ". {$group->getName()}\r\n";
                $height += 10;
            }

            $values[] = $user->getId();
            $values[] = $user->getName();
            $values[] = $user->getLogin();
            $values[] = $groups;

            foreach ($all_actions as $module => $module_actions) {
                foreach ($module_actions as $domain => $domain_actions) {
                    foreach ($domain_actions as $action_name => $action) {
                        $has_access = $access_to[$user->getId()][$module][$domain][$action_name]['has_access'];
                        $values[] = $has_access;
                    }
                }
            }
            $values['params'] = array('height' => array($row => $height), 'options' => $styleRow);
            $xls->addRow($values);
        }

        $xls->output("Права доступа", "access-" . date('d-m-Y') . ".xls");
        $this->view->assign('all', $all);
        $this->view->assign('access_to', $access_to);
        return $this->render('user/listPermission.tpl');
    }

    protected function getUserAccess($user)
    {
        $all_actions = array();
        $result = array();
        $userRoleMapper = $this->toolkit->getMapper('user', 'userRole');

              $user_groups = array();
        foreach ($user->getGroups() as $group) {
            $user_groups[] = $group->getName();
        }
         $files = glob('./websys/modules/*/actions/*');
         foreach ($files as $file) {
            preg_match('~modules/([^/]+)/actions/([^.]+)~', $file, $module_matches);
            $module_name = $module_matches[1];
            $domain_name = $module_matches[2];
            $result[$module_name][$domain_name] = array();
            $all_actions[$module_name][$domain_name] = array();
            $user_roles = array();
            foreach ($user->getGroups() as $group) {
                $roles = array();
                foreach ($userRoleMapper->getRolesGorGroup($module_name, $group->getId()) as $role) {
                    $roles[] = $role->getRole();
                }
                $user_roles = array_merge($user_roles, $roles);
            }

            $actions = include($file);
            if (!is_array($actions)) {
                continue;
            }
            $all_actions[$module_name][$domain_name] = $actions;
            foreach ($actions as $name => $action) {
                if (array_key_exists('role', $action) && !$user->isRoot() && !count(array_intersect($user_roles, $action['role']))) {
                    $actions[$name]['has_access'] = 'Нет';
                } else {
                    $actions[$name]['has_access'] = 'Есть';
                }
            }
             $result[$module_name][$domain_name] = $actions;

         }
         return array($result, $all_actions);
    }
}

?>