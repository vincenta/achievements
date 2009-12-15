<?php
// doesn't display links if $nolinks is true
// doesn't display menu if $nomenu it true
$editable = false;
if ($this->session['user']) {
    $editable = (($achievement->is_locked()) && ($this->session['user']->is_creator_of($achievement)));
}
?>

<p class="achievement" id="achievement_<?= $achievement->id ?>">
    <img class="achievementPix" src="<?= achievement_url($achievement) ?>" alt="<?= $achievement ?>"/>
    <? if (!$nolinks && $this->session['user']) : ?>
        <br/>
        <?= link_to(__('View details'), array('controller' => 'achievements', 'action' => 'details', 'id' => $achievement->id ), array('title' => __('View comments') )) ?>
    <? endif; ?>
</p>
<? if (!$nomenu && $editable) : ?>
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
