
<?php
    $author = $comment->author->target();
?>

<div class="comment">
    <div class="gravatar"><?= gravatar_tag($author); ?></div>
    <div class="details">
        <span class="author"><?= _f('Commented by %s, %s :', array($author, displayable_date($comment->created_on) )) ?></span>
        <blockquote><?= nl2br(htmlspecialchars($comment->body)) ?></blockquote>
    </div>
</div>

