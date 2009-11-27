<?php
$editable = false;
if ($this->session['user']) {
    $editable = (($achievement->is_locked()) && (!$this->session['user']->is_creator_of($this->achievement)));
}
?>

<p class="achievement" id="achievement_<?= $achievement->id ?>">
    <img class="achievementPix" src="<?= achievement_url($achievement) ?>" alt="<?= $achievement ?>"/>
    <?= ($achievement->is_new() ? '<img src="/images/silk/new.png" alt="new" class="newIcon"/>' : '') ?>
</p>
<? if ($editable) : ?>
<script type="text/javascript">
    $('#achievement_<?= $achievement->id ?> .achievementPix').achievementMenu({
        0: {
            title: '<?= __js('Edit') ?>',
            desc:  '<?= __js('Modify this achievement') ?>',
            url:   '<?= url_for(array('controller' => 'achievements', 'action' => 'update', 'id' => $achievement->id )) ?>',
            class: 'editLink'
        },
        1: {
            title: '<?= __js('Set the winner') ?>',
            desc:  '<?= __js('Set this achievement\'s winner') ?>',
            url:   '<?= url_for(array('controller' => 'achievements', 'action' => 'set_winner', 'id' => $achievement->id )) ?>',
            class: 'winnerLink'
        },
        2: {
            title: '<?= __js('Set as expired') ?>',
            desc:  '<?= __js('Set this achievement as expired') ?>',
            url:   '<?= url_for(array('controller' => 'achievements', 'action' => 'set_expired', 'id' => $achievement->id )) ?>',
            class: 'expiredLink'
        },
        3: {
            title: '<?= __js('Delete') ?>',
            desc:  '<?= __js('Delete this achievement') ?>',
            url:   '<?= url_for(array('controller' => 'achievements', 'action' => 'delete', 'id' => $achievement->id )) ?>',
            class: 'deleteLink'
        }
    });
</script>
<? endif; ?>
