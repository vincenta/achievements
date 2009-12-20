<?php

$map = new SRouteSet();
$map->home('', array('controller' => 'home', 'action' => 'index'));
$map->user_image('users/:filename', array(
    'controller' => 'users',
    'action'       => 'generate_image',
    'requirements' => array( ':filename'  => '/^[a-z0-9_]*\.png$/' )
));
$map->achievement_image('achievements/:filename', array(
    'controller' => 'achievements',
    'action'       => 'generate_image',
    'requirements' => array( ':filename'  => '/^[0-9]*\.png$/' )
));
$map->connect(':controller/:action/:id');

return $map;
