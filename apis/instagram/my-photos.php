<?php
require_once('./Instagram/InstagramUtils.class.php');
require_once('./Instagram/Instagram.class.php');

$Utils      = new InstagramUtils();
$Instagram  = new Instagram(1000);
$photos     = $Instagram->UserGetPhotos();
#$Utils->debug($photos);

?>


<?php foreach($photos as $p):?>
<figure>
    <img src="<?php echo $p['data']->images->standard_resolution->url;?>" width="30%" style="float: left;" />
</figure>
<?php endforeach; ?>
