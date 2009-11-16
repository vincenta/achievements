<?php

require(dirname(__FILE__).'/../achievement.php');

$pix = new AchievementPix('Devin','160 dans la presse en 2009, combien seront nous en 2010 ?','12 cafés, offerts par Quentin D.','unlocked');
$pix->saveImage('unlocked.png');
$pix = new AchievementPix('Devin','160 dans la presse en 2009, combien seront nous en 2010 ?','12 cafés, offerts par Quentin D.','locked');
$pix->saveImage('locked.png');
$pix = new AchievementPix('Devin','160 dans la presse en 2009, combien seront nous en 2010 ?','12 cafés, offerts par Quentin D.','expired');
$pix->saveImage('expired.png');

