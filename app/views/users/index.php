
<h1><?= __('Users ranking') ?></h1>

<? if (count($this->users)<=0) : ?>
    <p><?= __('No users found'); ?>.</p>
<? else : ?>
    <div class="usersList">
        <?= $this->render_partial_collection('share/user',$this->users); ?>
    </div>
<? endif; ?>


