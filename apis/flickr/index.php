<?php
require_once('./phpflickr/phpFlickr.php');
DEFINE('FLICKR_USER','53572347@N02');
DEFINE('FLICKR_API_KEY','8e04f641eb2354aa4de3333bf1ece363');
DEFINE('FLICKR_SECRET','49f92ed2cd7a9a93');

function d($a){
	echo '<pre style="font-family:\'Lucida Console\';font-size: 12px;padding: 20px;background: #fc0">'.print_r($a, true).'</pre>';
}
function getFlickrImages($limit){

	$f = new phpFlickr(FLICKR_API_KEY,FLICKR_SECRET);

	$photos = $f->photos_search (array(
            'user_id'=>FLICKR_USER,
            'machine_tags'=>-'uploaded:by=instagram',
            'extras'=>'url_n'
        ));
        d($photos);
	return $photos;
}
/*
 *
 * Get photos with the Instagram machine tags
 */
function getFlickrInstagramPhotos(){
 	$f = new phpFlickr(FLICKR_API_KEY,FLICKR_SECRET);

	$photos = $f->photos_search (array(
            'user_id'=>FLICKR_USER,
            'machine_tags'=>'uploaded:by=instagram',
            'extras'=>'url_o'
        ));

	return $photos;
}

?>

<h3>Instagram images</h3>
<?php
$insta_images = getFlickrInstagramPhotos();
foreach($insta_images['photo'] as $p):
?>
<img src="<?php echo $p['url_o'];?>" />
<?php endforeach;?>
<h3>Standard images</h3>
<?php
$flickr_images = getFlickrImages(10);
foreach($flickr_images['photo'] as $p):
?>
<img src="<?php echo $p['url_n'];?>" />
<?php endforeach;?>