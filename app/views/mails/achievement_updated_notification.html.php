<?php $achievement_url = url_for(array('controller' => 'achievements', 'action' => 'details', 'id' => $achievement->id)); ?>
<html>
    <head>
        <title>[ACHIEVEMENTS] Challenge updated by <?php echo $achievement->creator->target(); ?></title>
    </head>
    <body>
        <p>
            <img src="cid:<?php echo $image_cid; ?>" />
        </p>
        <p>
            <a href="<?php echo $achievement_url; ?>" title="See achievement details"><?php echo $achievement_url; ?></a>
        </p>
    </body>
</html>
