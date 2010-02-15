
<?php
    $author = $comment->author->target();
    $body = nl2br(htmlspecialchars($comment->body));
    $body = preg_replace('/http(s){0,1}:\/\/([^\s\(\)\{\}\|\\\^~\[\]<`]*)/e','\'<a href="http\1://\'.str_replace(\'"\',\'%22\',\'\2\').\'">\2</a>\'',$body);
?>

<div class="comment">
    <div class="gravatar"><?= gravatar_tag($author); ?></div>
    <div class="details">
        <span class="author"><?= _f('Commented by %s, %s :', array($author, displayable_date($comment->created_on) )) ?></span>
        <blockquote><?= $body ?></blockquote>
    </div>
</div>

