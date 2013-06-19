<?php
require_once('./Instagram/InstagramUtils.class.php');
require_once('./Instagram/Instagram.class.php');

$Utils      = new InstagramUtils();
$Instagram  = new Instagram(-1);
$photos     = $Instagram->UserGetPhotos();
?>


<?php foreach($photos as $p):?>
<figure style="position: relative;height: 200px;width: 200px;float: left;min-height:200px;margin: 0;">
    <img src="<?php echo $p['data']->images->standard_resolution->url;?>" width="200"/>
    <figcaption style="color: #fff;position: absolute;bottom: 0;padding: 5px;background: rgba(0,0,0,0.5); width: 190px;">
        <?php if(isset($p['data']->caption->text)):?>
        <p><?php echo $p['data']->caption->text;?></p>
        <?php endif;?>
        <time><?php echo date('d/m/Y, H:i:s', $p['pub_date']);?></time>
    </figcaption>
</figure>
<?php endforeach; ?>
