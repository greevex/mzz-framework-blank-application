<?php
//processTask actions config

return array (
    'listTask' =>
    array (
        'controller' => 'listTask',
        'crud_class' => 'processTask',
        'role' =>
        array (
        ),
    ),
    'addTask' =>
    array (
        'controller' => 'addTask',
        'main' => 'active.blank.tpl',
        'role' =>
        array (
        ),
    ),
    'deleteTask' =>
    array (
        'controller' => 'deleteTask',
        'crud_class' => 'processTask',
        'confirm' => 'Вы действительно хотите удалить эту задачу?',
        'main' => 'active.blank.tpl',
        'role' =>
        array (
        ),
    ),
    'addUpdateTask' =>
    array (
        'controller' => 'addUpdateTask',
        'crud_class' => 'processTask',
        'main' => 'active.blank.tpl',
        'role' =>
        array (
        ),
    ),
    'addReindexTask' =>
    array (
        'controller' => 'addReindexTask',
        'crud_class' => 'processTask',
        'main' => 'active.blank.tpl',
        'role' =>
        array (
        ),
    ),
);
?>