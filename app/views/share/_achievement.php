<?php
$editable = (($achievement->is_locked()) && (!$this->session['user']->is_creator_of($this->achievement)));
?>

<p class="achievement" id="achievement_<?= $achievement->id ?>">
    <img src="<?= achievement_url($achievement) ?>" alt="<?= $achievement ?>"/>
    <?= ($achievement->is_new() ? '<img src="/images/silk/new.png" alt="new" class="newIcon"/>' : '') ?>
    <span class="achievementEditOptions" style="visibility: hidden;">
<? if ($editable) : ?>
        <a href="<?= url_for(array('controller' => 'achievements', 'action' => 'update', 'id' => $achievement->id )) ?>" title="<?= __('Modify this achievement') ?>" class="editLink"><?= __('Edit') ?></a>
        -
        <a href="<?= url_for(array('controller' => 'achievements', 'action' => 'delete', 'id' => $achievement->id )) ?>" title="<?= __('Delete this achievement') ?>" class="deleteLink"><?= __('Delete') ?></a>
<? endif; ?>
    </span>
</p>
<? if ($editable) : ?>
<script type="text/javascript">
    var achievement = $('#achievement_<?= $achievement->id ?>');
    achievement.mouseover(function(){
        $(this).find('.achievementEditOptions').css('visibility','visible');
    });
    achievement.mouseout(function(){
        $(this).find('.achievementEditOptions').css('visibility','hidden');
    });
</script>
<? endif; ?>
