<?php
$creator = $achievement->creator->target();
$winner = $achievement->winner->target();

if ($achievement->is_locked()) {
    $state = __('Locked');
} elseif ($achievement->is_expired()) {
    $state = __('Expired');
} else {
    $state = _f('Won by %s',array($winner));
}
?>
<p>
    <img src="<?= achievement_url($achievement) ?>" alt="<?= $achievement ?>"/><br/>
    <?= $state ?>
</p>

