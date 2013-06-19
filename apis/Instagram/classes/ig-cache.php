<?

// the url for the instagram api call is passed as POST parameter
// e.g. https://api.instagram.com/v1/media/popular?client_id=1234567890abcdef
$url = $_POST["url"];

// SETUP 'time to live' for a cache entry, e.g. 5 minutes
$cacheTtl = '0:5:0';

// SETUP the connection to the database
mysql_connect('<HOST>', '<USER>', '<PWD>');
mysql_select_db('<DB_NAME>');
/*
CREATE TABLE IF NOT EXISTS `ig_cache` (
  `CACHE_ID` varchar(255) NOT NULL,
  `CONTENT` longtext NOT NULL,
  `HIT_COUNTER` int(11) NOT NULL DEFAULT '0',
  `RESPONSE_HEADER` text NOT NULL,
  `CREATED` datetime NOT NULL,
  PRIMARY KEY (`CACHE_ID`)
);
*/

$q = sprintf("delete from ig_cache where created < SUBTIME(NOW( ), '%s')", $cacheTtl);
mysql_query($q);

$q = sprintf("select * from ig_cache where CACHE_ID='%s'", mysql_real_escape_string($url));
$res = mysql_query($q);

$content = "<empty>";

$cacheHit = false;

if($res) {
	$r = mysql_fetch_assoc($res);
	
	if($r) {
		$content = $r['CONTENT'];
	
		$q = sprintf("update ig_cache set HIT_COUNTER = HIT_COUNTER+1 where CACHE_ID='%s'", mysql_real_escape_string($url));
		mysql_query($q);
		
		$cacheHit = true;
	}
}

if(!$cacheHit) {
	$content = file_get_contents($url);
	
	$response_header = implode("\n", $http_response_header);
	
	$q = sprintf(
        "INSERT INTO ig_cache (CACHE_ID, CONTENT, RESPONSE_HEADER, CREATED) VALUES('%s', '%s', '%s', NOW())",
        mysql_real_escape_string($url),
        mysql_real_escape_string($content),
        mysql_real_escape_string($response_header)
	);
	
	mysql_query($q);
}

mysql_close();

echo $content;

?>