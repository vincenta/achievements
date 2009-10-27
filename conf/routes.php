<?php

$map = new SRouteSet();
$map->home('', array('controller' => 'home', 'action' => 'index'));
$map->connect(':controller/:action/:id');

return $map;
