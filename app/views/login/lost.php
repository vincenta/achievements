
<h1><?= __('Login/Password reminder'); ?></h1>

<?= form_tag(array('action' => 'login')); ?>

    <?= $this->form; ?>

    <p><?= $this->flash['error']; ?></p>
    <?= $this->form->errors; ?>

    <?= submit_tag(__('Send me an email')); ?>

    <p><?= link_to(__('Back'), array('action' => 'login')); ?></p>

<?= end_form_tag(); ?>

