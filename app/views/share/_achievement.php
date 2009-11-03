<?php
$creator = $achievement->creator->target();
$winner = $achievement->winner->target();
$image = $achievement->trophy_url();

if ($achievement->is_locked()) {
    $state = __('Locked');
} elseif ($achievement->is_expired()) {
    $state = __('Expired');
} else {
    $state = _f('Won by %s',array($winner));
}
?>
<p>
    <img src="<?= encode_achievement_url($image) ?>" alt="<?= $achievement ?>"/>
    <?= _f('Reward %s (offered by %s)', array($achievement->reward,$creator)) ?><br/>
    <?= $state ?>
</p>

