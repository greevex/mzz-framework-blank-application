<?php
//schedulerTask actions config

return array (
    'listTask' =>
    array (
        'controller' => 'listTask',
        'crud_class' => 'schedulerTask',
        'role' =>
        array (
        ),
    ),
    'editTask' =>
    array (
        'controller' => 'saveTask',
        'title' => 'Сохранение задачи для планировщика',
        'main' => 'active.blank.tpl',
        'role' =>
        array (
        ),
    ),
    'addTask' =>
    array (
        'controller' => 'saveTask',
        'title' => 'Добавление новой задачи в планировщик',
        'crud_class' => 'schedulerTask',
        'role' =>
        array (
        ),
    ),
    'changeTaskStatus' =>
    array (
        'controller' => 'changeTaskStatus',
        'crud_class' => 'schedulerTask',
        'main' => 'active.blank.tpl',
        'confirm' => 'Деактивировать /Активировать эту задачу?',
        'role' =>
        array (
        ),
    ),
    'deleteTask' =>
    array (
        'controller' => 'deleteTask',
        'title' => 'Удалить задачу',
        'crud_class' => 'schedulerTask',
        'confirm' => 'Вы действительно хотите удалить эту задачу?',
        'role' =>
        array (
        ),
    ),
    'runTask' =>
    array (
        'controller' => 'runTask',
        'crud_class' => 'schedulerTask',
    ),
    'completedTask' =>
    array (
        'controller' => 'completedTask',
        'crud_class' => 'schedulerTask',
        'main' => 'active.blank.tpl',
        'role' =>
        array (
        ),
    ),
);
?>