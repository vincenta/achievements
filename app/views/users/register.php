
<h1><?= __('Sign up'); ?></h1>

<p><?= __('Create a new account, it\'s free and fun !'); ?></p>

<?= form_tag(array('controller' => 'users', 'action' => 'register')); ?>

    <?= $this->form; ?>

    <p><?= $this->flash['error']; ?></p>
    <?= $this->form->errors; ?>

    <?= submit_tag(__('Sign up')); ?>

<?= end_form_tag(); ?>

