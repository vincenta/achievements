<?php
$creator = $achievement->creator->target();
$winner = $achievement->winner->target();
if ($achievement->is_locked() || $achievement->expired) {
    $image = $achievement->locked_url;
    $state = ( $achievement->expired ? __('Expired') : __('Locked') );
} else {
    $image = $achievement->unlocked_url;
    $state = _f('Won by %s',array($winner));
}
?>
<p>
    <img src="<?= encode_achievement_url($image) ?>" alt="<?= $achievement ?>"/>
    <?= _f('Reward %s (offered by %s)', array($achievement->reward,$creator)) ?><br/>
    <?= $state ?>
</p>

