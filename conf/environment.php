<?php

date_default_timezone_set('Europe/Paris');

mb_internal_encoding("UTF-8");

$config->use_i18n = true;
$config->use_mailer = true;

// Add new inflection rules:
// (Example)
// SInflection::add_singular_rule('/games$/', 'game');
// SInflection::add_plural_rule('/game$/', 'games');

define('DEFAULT_MAIL_FROM','no-reply@'.$_SERVER['SERVER_NAME']);

