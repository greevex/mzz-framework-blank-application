<?php
//user actions config

return array (
    'edit' =>
    array (
        'controller' => 'save',
        'jip' => '1',
        'role' =>
        array (
            0 => 'moderator',
        ),
        'icon' => 'sprite:sys/user-edit',
        'title' => 'Редактировать',
    ),
    'memberOf' =>
    array (
        'controller' => 'memberOf',
        'jip' => '1',
        'role' =>
        array (
            0 => 'moderator',
        ),
        'icon' => 'sprite:sys/group',
        'title' => 'Группы',
        'main' => 'active.blank.tpl',
    ),
    'delete' =>
    array (
        'controller' => 'delete',
        'jip' => '1',
        'role' =>
        array (
            0 => 'moderator',
        ),
        'icon' => 'sprite:sys/user-del',
        'title' => 'Удалить',
        'confirm' => 'Вы хотите удалить этого пользователя?',
        'main' => 'active.blank.tpl',
    ),
    'activateEmail' =>
    array (
        'controller' => 'activateEmail',
        'jip' => '1',
        'icon' => '',
        'crud_class' => 'user',
    ),
    'listPermission' =>
    array (
        'controller' => 'listPermission',
        'title' => 'Список прав доступа',
        'jip' => '0',
        'icon' => '',
        'crud_class' => 'user',
        'role' => array(
            
        )
    ),
    'userSsoLogin' =>
    array (
        'controller' => 'userSsoLogin',
        'jip' => '0',
        'icon' => '',
        'crud_class' => 'user',
    ),
);
?>