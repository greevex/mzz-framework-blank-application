<?php
//notification actions config

return array (
    'show' =>
    array (
        'controller' => 'show',
        'crud_class' => 'notification',
    ),
    'close' =>
    array (
        'controller' => 'show',
        'crud_class' => 'notification',
    ),
    'add' =>
    array (
        'controller' => 'add',
        'role' =>
        array (
            'root'
        ),
    ),
    'list' =>
    array (
        'controller' => 'list',
        'crud_class' => 'notification',
    ),
    'edit' =>
    array (
        'controller' => 'add',
        'role' => array(
            'root'
        )
    ),
    'delete' =>
    array (
        'controller' => 'delete',
        'crud_class' => 'notification',
        'role' => array(
            'root'
        )
    ),
);
?>