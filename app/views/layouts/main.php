<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Hall of Fame</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?= javascript_include_tag($_SERVER['STATO_ENV']=='production' ? 'jquery-1.3.2.min.js' : 'jquery-1.3.2.js'); ?>
    <? foreach ($this->extra['js'] as $js_file) : ?>
        <?= javascript_include_tag($js_file); ?>
    <? endforeach; ?>

    <?= stylesheet_link_tag('main.css'); ?>
    <? foreach ($this->extra['css'] as $css_file) : ?>
        <?= stylesheet_link_tag($css_file); ?>
    <? endforeach; ?>

</head>
<body>
    <div id="body">
        <div id="content">

            <div id="main">
<? if (isset($this->session['user'])) : ?>
                <div id="userBar">
                    <?= _f('Connected as %s',array($this->session['user'])) ?>
                    -
                    <?= link_to(__('View all'), array('controller' => 'home')); ?>
                    -
                    <?= link_to(__('Create an achievement'), array('controller' => 'achievements', 'action' => 'create')); ?>
                    -
                    <?= link_to(__('Logout'), array('controller' => 'login', 'action' => 'logout')); ?>
                </div>
<? else : ?>
                <div id="anonymBar">
                    <?= __('Not logged in') ?>
                    -
                    <?= link_to(__('Login'), array('controller' => 'login', 'action' => 'login')); ?>
                    -
                    <?= link_to(__('Register'), array('controller' => 'users', 'action' => 'register')); ?>
                </div>
<? endif; ?>

                <?= $this->layout_content; ?>

            </div>
            &nbsp;
        </div>

    </div>

    <div id="foot">
        <?= __('Achievements is free software released under the terms of the GNU Affero General Public License') ?>
        (<a href="http://github.com/vincenta/achievements" title="<? __('Achievements github project homepage') ?>"><?= __('Project homepage') ?></a>).
    </div>

</body>
</html>
