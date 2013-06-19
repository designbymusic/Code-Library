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


<?php foreach($tweets as $t):?>
<?php if(isset($t['media'])):?>
<img src="<?php echo $t['media'];?>" />
<?php endif;?>
<?php endforeach; ?>
