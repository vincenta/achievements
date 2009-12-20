<?php

require(dirname(__FILE__).'/../achievement.php');

$pix = new AchievementPix('Devin','160 dans la presse en 2009, combien seront nous en 2010 ?','12 cafés, offerts par Quentin D.','unlocked');
$pix->save('unlocked.png');
$pix = new AchievementPix('Devin','160 dans la presse en 2009, combien seront nous en 2010 ?','12 cafés, offerts par Quentin D.','locked');
$pix->save('locked.png');
$pix = new AchievementPix('Devin','160 dans la presse en 2009, combien seront nous en 2010 ?','12 cafés, offerts par Quentin D.','expired');
$pix->save('expired.png');

