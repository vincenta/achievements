<?php

function encode_achievement_url($url) {
    return str_replace(array(' ','"'),array('%20','%22'), $url);
}

