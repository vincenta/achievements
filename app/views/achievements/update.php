
<h1><?= __('Update an achievement'); ?></h1>

<p><?= __('Achievements can only be updated while they are still locked !'); ?></p>

<p class="achievement" id="achievement_<?= $this->achievement->id ?>">
    <img class="achievementPix" src="<?= achievement_url($this->achievement) ?>" alt="<?= $this->achievement ?>"/>
</p>

<?= form_tag(array('controller' => 'achievements', 'action' => 'update', 'id' => $this->achievement->id)); ?>

    <?= $this->form; ?>

    <? if (!empty($this->flash['error'])) : ?>
        <p class="error"><?= $this->flash['error']; ?></p>
    <? endif; ?>

    <?= submit_tag(__('Update !')); ?>

<?= end_form_tag(); ?>

