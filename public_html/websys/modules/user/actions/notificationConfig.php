<?php
//notificationConfig actions config

return array (
    'listNotificationConfig' =>
    array (
        'controller' => 'listNotificationConfig',
        'title' => 'Список оповещений',
        'main' => 'active.admin.tpl',
        'crud_class' => 'notificationConfig',
        'admin' => true,
        'role' => array(

        )
    ),
    'deleteNotificationConfig' =>
    array (
        'controller' => 'deleteNotificationConfig',
        'crud_class' => 'notificationConfig',
        'role' => array(

        )
    ),
    'addNotificationConfig' =>
    array (
        'controller' => 'saveNotificationConfig',
        'main' => 'active.blank.tpl',
        'role' => array(

        )
    ),
    'editNotificationConfig' =>
    array (
        'controller' => 'saveNotificationConfig',
        'main' => 'active.blank.tpl',
        'crud_class' => 'notificationConfig',
        'role' => array(

        )
    ),
);
?>