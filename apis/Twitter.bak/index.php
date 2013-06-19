<?php
require_once('twitter.php');
$T = new Twitter('designbymusic',10);
$tweets = $T->getTweets('single_user', 1);
d($tweets);
?>
