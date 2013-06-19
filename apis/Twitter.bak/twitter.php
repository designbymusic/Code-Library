<?php
require_once('utils.php');
class Twitter {

    protected $username;
    protected $tweetcount;
    var $cache_dir;
    var $expire_time = 0;

    public function __construct($username, $tweetcount) {
        date_default_timezone_set('Europe/London');
        $this->cache_dir = '../cache/twitter/tweets';
        //$this->expire_time  = $time_expire = time() + 24*60*60;
        //$this->expire_time  = 15*60;

        $this->_makeCachePath($this->cache_dir);

        $this->username = $username;
        $this->tweetcount = $tweetcount;
    }

    /**
     *
     * @return type
     */
    public function getTweets($type, $limit) {

        switch($type){
            case 'mentions':

                //$this->_curlDownload(curl --get 'https://api.twitter.com/1/' --header 'Authorization: OAuth oauth_consumer_key="3zO6SRSbMx8ZFKIk6WW9qA", oauth_nonce="3675a015158a6db1b608b15d33b6f386", oauth_signature="VzvjVQKaB9yCBgYznfeEOMlZ%2Fjo%3D", oauth_signature_method="HMAC-SHA1", oauth_timestamp="1354196981", oauth_token="63937728-YflFiHIXEr39dkS6uTITqWHMG5kmBhG5PuWh1atZA", oauth_version="1.0"' --verbose);

            break;
            case 'single_user':
                $twitter_feed = $this->_curlDownload('http://api.twitter.com/1/statuses/user_timeline.json?count=' . $this->tweetcount . '&screen_name=' . $this->username);
            break;
            default:
                $twitter_feed = $this->_curlDownload('http://api.twitter.com/1/statuses/user_timeline.json?count=' . $this->tweetcount . '&screen_name=' . $this->username);
            break;
        }


        $tweets = json_decode($twitter_feed, false);


        $tweets = $this->_cacheTweets($tweets);

        return $tweets;
        exit();
    }

    /**
     *
     * @desc    Checks if tweet cache file exists. If not, we write the file, and return it's contents
     * @param type json file contents of cached file
     * @return type
     */
    private function _cacheTweets($tweets) {
        $cache_file = $this->cache_dir . DIRECTORY_SEPARATOR . 'tweets';
        if (file_exists($cache_file)) {
            $cache_age = time() - filemtime($cache_file);
        } else {
            $cache_age = 0;
        }
        if (file_exists($cache_file) && $cache_age <= $this->expire_time) {
            return $this->_decodeTweets(file_get_contents($cache_file));
        } else {
            file_put_contents($cache_file, json_encode($tweets));
            return $this->_decodeTweets(file_get_contents($cache_file));
        }
    }

    private function _decodeTweets($data) {
        $data = mb_convert_encoding($data, 'UTF-8');
        $data = preg_replace('/\\\u([0-9a-z]{4})/', '&#x$1;', $data);

        return $this->_parseTweets(json_decode($data, true));
    }

    private function _parseTweets($tweets) {

        $i = 0;
        foreach ($tweets as $tweet) {

            $t = $tweet;

            // link URLs
            $t['text_parsed'] = " " . preg_replace("/(([[:alnum:]]+:\/\/)|www\.)([^[:space:]]*)([[:alnum:]#?\/&=])/i", "<a href=\"\\1\\3\\4\" target=\"_blank\">\\1\\3\\4</a>", $t['text']);

            // link mailtos
            $t['text_parsed'] = preg_replace("/(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)" .
                    "([[:alnum:]-]))/i", "<a href=\"mailto:\\1\">\\1</a>", $t['text_parsed']);

            //link twitter users
            $t['text_parsed'] = preg_replace("/ +@([a-z0-9_]*) ?/i", " <a href=\"http://twitter.com/\\1\" target=\"_blank\">@\\1</a> ", $t['text_parsed']);

            //link twitter arguments
            $t['text_parsed'] = preg_replace("/ +#([a-z0-9_]*) ?/i", " <a href=\"http://twitter.com/search?q=%23\\1\" target=\"_blank\">#\\1</a> ", $t['text_parsed']);

            // truncates long urls that can cause display problems (optional)
            $t['text_parsed'] = preg_replace("/>(([[:alnum:]]+:\/\/)|www\.)([^[:space:]]" .
                    "{30,40})([^[:space:]]*)([^[:space:]]{10,20})([[:alnum:]#?\/&=])" .
                    "</", ">\\3...\\5\\6<", $t['text_parsed']);
            $parsed_tweets[$i]['count'] = $i;
            $parsed_tweets[$i]['created'] = strtotime($t['created_at']);
            $parsed_tweets[$i]['tweet'] = preg_replace('/%u([a-fA-F0-9]{4})/', '&#x\\1;', $t['text_parsed']);
            $parsed_tweets[$i]['username'] = $this->username;
            $i++;
        }

        return $parsed_tweets;
    }

    private function _curlDownload($Url) {

        // is cURL installed yet?
        if (!function_exists('curl_init')) {
            die('Sorry cURL is not installed!');
        }

        // OK cool - then let's create a new cURL resource handle
        $ch = curl_init();
        // Now set some options (most are optional)
        // Set URL to download
        curl_setopt($ch, CURLOPT_URL, $Url);
        // Set a referer
        curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
        // User agent
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        // Include header in result? (0 = yes, 1 = no)
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // Download the given URL, and return output
        $output = curl_exec($ch);
        // Close the cURL resource, and free system resources
        curl_close($ch);
        return $output;
    }
    private function _makeCachePath($path) {
        //Test if path exist
        if (is_dir($path) || file_exists($path)) return;
        //No, create it
        mkdir($path, 0777, true);
    }

}