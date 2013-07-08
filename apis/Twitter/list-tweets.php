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
$tweets     = $Twitter->getTweetsFromList();
#debug($tweets);
?>

<ul>
<?php foreach($tweets as $t):?>
<li>
    <article>
        <blockquote>
            <p><?php echo $t['data']->text;?></p>
            <cite><a href="<?php echo $t['data']->user->url;?>"><?php echo $t['data']->user->screen_name;?></a></cite>
           </blockquote>
        </article>
</li>
<?php endforeach; ?>
</ul>