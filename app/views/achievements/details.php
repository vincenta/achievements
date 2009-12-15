
<?php
    $creator = $this->achievement->creator->target();
?>

<h1><?= __('Achievement details'); ?></h1>

<?= $this->render_partial('share/achievement', array('achievement' => $this->achievement, 'nolinks' => true)); ?>

<div class="achievementDetails">
    <div class="gravatar"><?= gravatar_tag($creator); ?></div>
    <div class="details">
        <?php
        echo _f('Created by %s, %s.', array($creator, displayable_date($this->achievement->created_on)));

        if ($this->achievement->updated_on > $this->achievement->created_on)
            echo "<br/>\n"._f('Updated %s.', displayable_date($this->achievement->updated_on));

        echo "<br/>\n"._f('Reward : %s.', $this->achievement->reward);

        if ($this->achievement->is_expired())
            echo "<br/>\n".__('Expired');

        if ($this->achievement->is_unlocked())
            echo "<br/>\n"._f('Won by %s',$this->achievements->winner->target());
        ?>
    </div>
</div>


