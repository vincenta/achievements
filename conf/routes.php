<?php

$map = new SRouteSet();
$map->home('', array('controller' => 'home', 'action' => 'index'));
$map->user_image('images/users/:filename', array(
    'controller' => 'users',
    'action'       => 'generate_image',
    'requirements' => array( 'filename'  => '/[a-z0-9]*$/' )
));
$map->achievement_image('images/achievements/:filename', array(
    'controller' => 'achievements',
    'action'       => 'generate_image',
    'requirements' => array( 'filename'  => '/[0-9]*$/' )
));
$map->connect(':controller/:action/:id');

return $map;
