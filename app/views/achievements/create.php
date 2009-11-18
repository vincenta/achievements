
<h1><?= __('Add a new achievement'); ?></h1>

<p><?= __('Challenge other users by creating a new achievement !'); ?><br/>
<?= __('Don\'t forget to stimulate them with an amazing reward...'); ?></p>

<?= form_tag(array('controller' => 'achievements', 'action' => 'create')); ?>

    <?= $this->form; ?>

    <p><?= $this->flash['error']; ?></p>
    <?= $this->form->errors; ?>

    <?= submit_tag(__('Create !')); ?>

<?= end_form_tag(); ?>

