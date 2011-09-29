<?php
//blog actions config

return array (
    'view' => 
    array (
        'controller' => 'view',
        'title' => 'Запись',
        'crud_class' => 'blog',
    ),
    'list' => 
    array (
        'controller' => 'list',
        'title' => 'Все записи',
        'crud_class' => 'blog',
    ),
    'byTags' => 
    array (
        'controller' => 'byTags',
        'title' => 'По тегам',
        'crud_class' => 'blog',
    ),
    'save' => 
    array (
        'controller' => 'save',
        'title' => 'Создать',
        'crud_class' => 'blog',
        'admin' => true,
        'icon' => '',
        'jip' => true,
        'role' => 
        array (
            0 => 'moderator',
            1 => 'admin',
        ),
    ),
    'edit' => 
    array (
        'controller' => 'save',
        'title' => 'Редактировать',
        'crud_class' => 'blog',
        'icon' => '',
        'jip' => true,
        'role' => 
        array (
            0 => 'moderator',
            1 => 'admin',
        ),
    ),
    'delete' => 
    array (
        'controller' => 'delete',
        'crud_class' => 'blog',
        'icon' => '',
        'jip' => true,
        'confirm' => 'Вы действительно желаете удалить эту запись?',
        'role' => 
        array (
            0 => 'moderator',
            1 => 'admin',
        ),
    ),
    'getComments' => 
    array (
        'controller' => 'getComments',
        'title' => 'Загрузить комменты',
        'main' => '',
        'jip' => '0',
        'icon' => '',
        'crud_class' => 'blog',
    ),
);
?>