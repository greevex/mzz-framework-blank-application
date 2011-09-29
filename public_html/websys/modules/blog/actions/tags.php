<?php
//tags actions config

return array (
    'update' => 
    array (
        'controller' => 'update',
        'title' => 'Добавить\\обновить тег',
        'main' => '',
        'crud_class' => 'tags',
    ),
    'deleteTag' => 
    array (
        'controller' => 'deleteTag',
        'title' => 'Удалить тег',
        'crud_class' => 'tags',
    ),
);
?>