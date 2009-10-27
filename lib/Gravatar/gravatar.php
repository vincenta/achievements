<?php

class Gravatar {

    public static function build_gravatar_url($email, $size=40) {
        $url = "http://www.gravatar.com/avatar.php?gravatar_id=%s&size=%d";
        return sprintf($url, md5(strtolower($email)), $size);
    }

}
