<?php

require_once('./config.php');


/*
 * Instagram
 * @desc A very basic class to conect to the Instagram API
 */

class Instagram {

    /**
     *      To get the code, vsit the following URL, replacing the parameters
     *      https://api.instagram.com/oauth/authorize/?client_id=$client_id&redirect_uri=$redirect_uri&response_type=code
     *
     *      Issue the command below, in Terminal, replacing the required variables
     *
     *      curl \-F 'client_id=$client_id' \
     *      -F 'client_secret=$client_secret' \
     *      -F 'grant_type=authorization_code' \
     *      -F 'redirect_uri=http://sandbox.localhost/apis/instagram/callback.php' \
     *       F 'code=$code' \https://api.instagram.com/oauth/access_token
     */

    /**
     *      API related properties
     */
    private $access_token = '989139.9b71628.ec1928f64d8c4e58aa9f5a7ccafb4ccd';
    private $code = '7774dc3ee1814d63bfd4c8eb9fb9e34c';
    private $client_id = '9b7162869c0240788b6126edff629ea2';
    private $client_secret = '97437a9cbbef4dab80e7affed7a56ee8';
    private $user_id = '989139'; // Can be obtained here http://jelled.com/instagram/lookup-user-id
    private $redirect_uri = 'http://sandbox.localhost/apis/instagram/callback.php';
    private $itemcount = -1; // Unlimited

    /**
     *     Utility properties
     */
    private $api_name       = 'instagram';
    private $cache_length   = 6000;
    private $cache_path      = 'apis/instagram/cache';



    /**
     * __construct()
     * @param type $itemcount
     */
    public function __construct($itemcount) {
        $this->itemcount = $itemcount;
    }


    /**
     * Get the photos from users' own photo feed
     *
     * @desc    Initializes the cache if the apiFileCache class exists (is included)
     *          Fetches the new data if the cache has not been initialised
     *          If cache is initilaised, then writes newly fethed data to the cache
     * @return type
     */
    public function UserGetPhotos() {
        $this->_initCache('userphotos');
        $feed = $this->cache->fetchCacheData('userphotos');
        if (!$feed) {
            $feed = json_decode($this->_curlDownload('https://api.instagram.com/v1/users/' . $this->user_id . '/media/recent/?access_token=' . $this->access_token . '&count=' . $this->itemcount));
            $this->cache->writeCacheData($feed, 'userphotos');
        }
        return $this->_normalizeData($feed);
    }
    /**
     * Get the photos from users' feed of ho he is following
     * @todo Need to query all pages to get all photos
     * @return type
     */
    public function getRecentFromFeed() {
        $this->_initCache('userfeed');
        $feed = $this->cache->fetchCacheData('userfeed');
        if (!$cache) {
            $feed = json_decode($this->_curlDownload('https://api.instagram.com/v1/users/self/feed?access_token='.$this->access_token.'&count='.$this->itemcount));
            $this->cache->writeCacheData($feed, 'userfeed');
        }
        return $this->_normalizeData($feed);
    }

    private function _initCache($type){
        $feed = false;
        try {
            $this->cache = new apiFileCache($this->api_name, $type,$this->cache_length, $this->cache_path);
        } catch (Exception $e) {
            echo $e->getMessage(), "\n";
        }

        #}else{
            //echo 'Please make sure you have included '
        #}
        return $feed;
    }

    private function _normalizeData($feed){
        $normalized_data = array();
        $i = 0;

        foreach ($feed->data as $data){
            $normalized_data[$i]['pub_date']    = $data->created_time;
            $normalized_data[$i]['data']        = $data;
            $normalized_data[$i]['type']        = $this->api_name;
            $i++;
        }

        return $normalized_data;
    }

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
    function debug($a) {
        echo '<pre>' . print_r($a, true) . '</pre>';
    }


}


?>
