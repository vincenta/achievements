
<h1><?= __('Trophy Room') ?></h1>

<? if (count($this->trophies)<=0) : ?>
    <p><?= __('Trophy room is empty'); ?>.</p>
<? else : ?>
    <div class="achievementsList">
        <?= $this->render_partial_collection('share/achievement',$this->trophies); ?>
    </div>
<? endif; ?>

<h1><?= __('New challenges (still locked)') ?></h1>

<? if (count($this->locked)<=0) : ?>
    <p><?= __('No new challenges'); ?>.</p>
<? else : ?>
    <div class="achievementsList">
        <?= $this->render_partial_collection('share/achievement',$this->locked); ?>
    </div>
<? endif; ?>

<h1><?= __('Expired challenges (will never be unlocked)') ?></h1>

<? if (count($this->expired)<=0) : ?>
    <p><?= __('No new challenges'); ?>.</p>
<? else : ?>
    <div class="achievementsList">
        <?= $this->render_partial_collection('share/achievement',$this->expired); ?>
    </div>
<? endif; ?>

<h1><?= __('See also...') ?></h1>

