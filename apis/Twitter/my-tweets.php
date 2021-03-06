<?php
require_once('./classes/Twitter.class.php');

/*
 * @desc Debug and array or object
 * @return void
 *
 */
function debug($a) {
    echo '<pre>' . print_r($a, true) . '</pre>';
}

$Twitter  = new Twitter(1000);
$tweets     = $Twitter->UserGetTweets();
?>
<h1><cite><a href="http://www.twitter.com/<?php echo $tweets[0]['data']->user->screen_name;?>">@<?php echo $tweets[0]['data']->user->screen_name;?>&rsquo;s tweets</a></cite></h1>
<ul>
<?php foreach($tweets as $t):?>
<li>
    <article>
        <blockquote>
            <p><?php echo $t['data']->text;?></p>

           </blockquote>
        </article>
</li>
<?php endforeach; ?>
</ul>
