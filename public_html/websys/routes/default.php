<?php
$router->addRoute('default', new requestRoute('', array('module' => 'blog', 'action' => 'list', 'id' => "")));
$router->addRoute('updateRemains', new requestRoute('updateRetails', array('module' => 'center', 'action' => 'update', 'type' => "production_remain")));
?>