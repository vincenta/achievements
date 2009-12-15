
<?php
    $creator = $this->achievement->creator->target();
?>

<h1><?= __('Achievement details'); ?></h1>

<?= $this->render_partial('share/achievement', array('achievement' => $this->achievement, 'nolinks' => true)); ?>

<div class="achievementDetails">
    <div class="gravatar"><?= gravatar_tag($creator); ?></div>
    <div class="details">
        <?php
        echo '<span class="author">'._f('Created by %s, %s.', array($creator, displayable_date($this->achievement->created_on))).'</span>';

        if ($this->achievement->updated_on > $this->achievement->created_on)
            echo "<br/>\n"._f('Updated %s.', displayable_date($this->achievement->updated_on));

        echo "<br/>\n"._f('Reward : %s.', $this->achievement->reward);

        if ($this->achievement->is_expired())
            echo "<br/>\n".__('Expired');

        if ($this->achievement->is_unlocked())
            echo "<br/>\n"._f('Won by %s',$this->achievement->winner->target()->__toString());
        ?>
    </div>
</div>

<? if (count($this->comments)<=0) : ?>
    <p><?= __('No comments on this achievement'); ?>.</p>
<? else : ?>
    <div class="commentsList">
        <?= $this->render_partial_collection('share/comment',$this->comments); ?>
    </div>
<? endif; ?>

<h1><?= __('Posting a comment'); ?></h1>

<?= form_tag(array('controller' => 'achievements', 'action' => 'comment', 'id' => $this->achievement->id)); ?>

    <?= $this->form; ?>

    <? if (!empty($this->flash['error'])) : ?>
        <p class="error"><?= $this->flash['error']; ?></p>
    <? endif; ?>

    <?= submit_tag(__('Comment !')); ?>

<?= end_form_tag(); ?>

