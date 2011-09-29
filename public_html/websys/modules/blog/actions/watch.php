<?php
//watch actions config

return array (
    'updateModules' => 
    array (
        'controller' => 'updateModules',
        'crud_class' => 'watch',
        'admin' => true,
        'jip' => '0',
        'title' => 'Обновить модули',
        'role' => 
        array (
            0 => 'moderator',
            1 => 'admin',
        ),
    ),
    'activate' => 
    array (
        'controller' => 'activate',
        'title' => 'Активировать',
        'jip' => '1',
        'icon' => '',
        'crud_class' => 'watch',
    ),
    'deactivate' => 
    array (
        'controller' => 'deactivate',
        'title' => 'Отключить',
        'jip' => '1',
        'icon' => '',
        'crud_class' => 'watch',
    ),
    'listModules' => 
    array (
        'controller' => 'listModules',
        'title' => 'Список модулей',
        'jip' => '0',
        'icon' => '',
        'crud_class' => 'watch',
        'admin' => true,
        'role' => 
        array (
            0 => 'moderator',
            1 => 'admin',
        ),
    ),
    'lookup' => 
    array (
        'controller' => 'lookup',
        'title' => 'Проверить обновления',
        'jip' => '0',
        'icon' => '',
        'crud_class' => 'watch',
        'admin' => true,
    ),
);
?>