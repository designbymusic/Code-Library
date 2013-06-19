<?php
defined('DS') or define('DS',DIRECTORY_SEPARATOR);
require_once ('../classes'.DIRECTORY_SEPARATOR.'apiFileCache.php');
require_once ('twitteroauth'.DIRECTORY_SEPARATOR.'TwitterOAuth.php');
class Twitter {

    private $api_domain = 'https://api.twitter.com';
    private $api_key = '3zO6SRSbMx8ZFKIk6WW9qA';
    private $api_secret = '4ggezgCjwlxZadfsq0BiBucG56q7BMnGOcrZMLQU';
    private $oauth_token = '63937728-YflFiHIXEr39dkS6uTITqWHMG5kmBhG5PuWh1atZA';
    private $oauth_token_secret = 'ej6VrCh68SJUlbcgnEQAwN8x1YzSkjWSpsofyO94rc';
    private $multiple_user_list = 'music';
    private $user_id = '';
    private $username = 'ideasbymusic';
    private $access_token = '';
    private $num_combined_feeds = 1;
    private $feed_type_id = 1;
    protected $itemcount;
    /**
     *     Utility properties
     */
    private $api_name       = 'twitter';
    private $cache_length   = 6000;
    private $cache_path      = 'apis/cache';

    public function __construct($itemcount) {
        $this->itemcount = $itemcount;
        $this->twitconn = new TwitterOAuth($this->api_key, $this->api_secret, $this->oauth_token, $this->oauth_token_secret);
    }

    public function UserGetTweets() {
        $this->_initCache('usertweets');
        $feed = json_decode($this->cache->fetchCacheData('userphotos'));
        if (!$feed) {
            $feed = $this->twitconn->get("statuses/user_timeline", array(
                'count' => 200
            ));
            $this->cache->writeCacheData(json_encode($feed), 'usertweets');
        }
        return $this->_normalizeData($feed);
    }

    /**
     * Initialise the cache class to enable file caching
     * @return objects
     */
    private function _initCache($type){
        $feed = false;
        try {
            $this->cache = new apiFileCache($this->api_name, $type,$this->cache_length, $this->cache_path);
        } catch (Exception $e) {
            echo $e->getMessage(), "\n";
            exit();
        }
        return $feed;
    }

    /**
     * Convert the data to a set format
     * @return array
     */
    private function _normalizeData($feed){
        $normalized_data = array();
        $i = 0;

        foreach ($feed as $data){
            $normalized_data[$i]['pub_date']    = $data->created_at;
            $normalized_data[$i]['data']        = $data;
            $normalized_data[$i]['tweet']       = $this->_parseTweet($data);
            $normalized_data[$i]['type']        = $this->api_name;
            if($this->_getTweetMedia($data)){
                $normalized_data[$i]['media']       = $this->_getTweetMedia($data);
            }

            $i++;
        }

        return $normalized_data;
    }

    private function _getTweetMedia($tweet) {
        if (isset($tweet->entities->media)) {
            return $tweet->entities->media[0]->media_url;
        } else {
            return false;
        }
    }
    private function _parseTweet($tweet) {

        //$t['raw'] = $tweet->text;
        // link URLs
        $t['parsed'] = " " . preg_replace("/(([[:alnum:]]+:\/\/)|www\.)([^[:space:]]*)([[:alnum:]#?\/&=])/i", "<a href=\"\\1\\3\\4\" target=\"_blank\">\\1\\3\\4</a>", $tweet->text);
        // link mailtos
        $t['parsed'] = preg_replace("/(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)" .
                "([[:alnum:]-]))/i", "<a href=\"mailto:\\1\">\\1</a>", $t['parsed']);
        //link twitter users
        $t['parsed'] = preg_replace("/ +@([a-z0-9_]*) ?/i", " <a href=\"http://twitter.com/\\1\" target=\"_blank\">@\\1</a> ", $t['parsed']);
        //link twitter arguments
        $t['parsed'] = preg_replace("/ +#([a-z0-9_]*) ?/i", " <a href=\"http://twitter.com/search?q=%23\\1\" target=\"_blank\">#\\1</a> ", $t['parsed']);
        // truncates long urls that can cause display problems (optional)
        $t['parsed'] = preg_replace("/>(([[:alnum:]]+:\/\/)|www\.)([^[:space:]]" .
                "{30,40})([^[:space:]]*)([^[:space:]]{10,20})([[:alnum:]#?\/&=])" .
                "</", ">\\3...\\5\\6<", $t['parsed']);

        $t = preg_replace('/%u([a-fA-F0-9]{4})/', '&#x\\1;', $t['parsed']);

        return $t;
    }


    /*     * ****** -----------------------------------------------------------------*** */


    private function _getNewTweets() {

        $statement = $this->pdo->prepare('SELECT * FROM cache WHERE feed_type_id=:feed_type_id ORDER BY pub_date DESC LIMIT 1');
        $statement->execute(array(':feed_type_id' => $this->feed_type_id));
        $row = $statement->fetch();

        $content = $this->conn->get("statuses/user_timeline", array(
            'count' => 200,
            'since_id' => $row['id_str']
        ));

        $this->_cacheTweetsToDB($content);
        return $this->_fetchCachedTweets();
    }

    /*     * ****** -----------------------------------------------------------------*** */


    /**
     * Utility functions
      ------------------------------------------------------------------------- */
    /*
     * _curlDownload
     *
     * @desc Utility function to curl a URL
     * @return mixed    Returned response
     *
     */
    private function _curlDownload($Url) {
        if (!function_exists('curl_init')) {
            die('Sorry cURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
    /*
     * @desc Debug and array or object
     * @return void
     *
     */
    function debug($a) {
        echo '<pre>' . print_r($a, true) . '</pre>';
    }
}