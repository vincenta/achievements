
<h1><?= __('Set the achievement\'s winner'); ?></h1>

<?= $this->render_partial('share/achievement',array('achievement'=>$this->achievement)); ?>

<?= form_tag(array('controller' => 'achievements', 'action' => 'set_winner', 'id' => $this->achievement->id)); ?>

    <?= $this->form; ?>

    <? if (!empty($this->flash['error'])) : ?>
        <p class="error"><?= $this->flash['error']; ?></p>
    <? endif; ?>

    <?= submit_tag(__('Set the winner !')); ?>

<?= end_form_tag(); ?>

