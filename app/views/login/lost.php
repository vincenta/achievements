
<h1><?= __('Login/Password reminder'); ?></h1>

<?= form_tag(array('action' => 'lost')); ?>

    <?= $this->form; ?>

    <? if (!empty($this->flash['error'])) : ?>
        <p class="error"><?= $this->flash['error']; ?></p>
    <? endif; ?>

    <?= submit_tag(__('Send me an email')); ?>

    <p><?= link_to(__('Back'), array('action' => 'login')); ?></p>

<?= end_form_tag(); ?>

