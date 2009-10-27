
<h1><?= __('Log in'); ?></h1>

<?= form_tag(array('action' => 'login')); ?>

    <? if (isset($this->params['return_to'])) : ?>
        <input type="hidden" name="return_to" value="<?= $this->params['return_to']; ?>" />
    <? endif; ?>

    <?= $this->form; ?>

    <p><?= $this->flash['error']; ?></p>
    <?= $this->form->errors; ?>

    <?= submit_tag(__('Log in')); ?>

    <p>
    <?= link_to(__('If you have forget your login and/or password click here.'),
        array('action' => 'lost')); ?></p>

<?= end_form_tag(); ?>

