<?php

require_once('./config.php');

/*
 * Instagram
 * @desc Basic methods used to connect to the Instagram API
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

    /**
     *     Utility properties
     */
    private $api_name = 'instagram';
    private $cache_length = 90;
    private $use_db_cache = true;

    /**
     * __construct()
     * @param type $itemcount
     */
    public function __construct($itemcount) {
        $this->itemcount = -1;

        if ($this->use_db_cache == true) {
            $this->cache = new apiDbCache($this->api_name, $this->cache_length);
        }
    }

    /**
     * Get the photos from users' own feed
     * @return type
     */
    public function UserGetRecent() {

        #$feed = $this->cache->fetchCachedData('user');

        if ($feed) {
           echo 'here';
           return $feed;
        } else {
            $feed = $this->_curlDownload('https://api.instagram.com/v1/users/' . $this->user_id . '/media/recent/?access_token=' . $this->access_token . '&count=' . $this->itemcount);
            $this->debug(json_decode($feed));
            $this->cache->saveCacheData($feed, 'user');
        }

        return $feed;
    }

    /** ------------------------------------------------------------------------
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

class apiDbCache {

    /*
     *      __construct
     *
     *      @param   string  the reference used for the API in the DB
     *      @param   int     The time, in seconds, for which we want to cache the data
     *      @return void
     * */

    public function __construct($api_name, $cache_length) {
        $this->comp_time = time();
        $this->api_name = $api_name;
        $this->cache_length = $cache_length;
        $this->cache_threshold = $this->comp_time - $this->cache_length;

        $this->pdo = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB, MYSQL_USER, MYSQL_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$this->_checkLastCacheTime();
    }

    /*
     *  _checkLastCacheTime
     *  @desc    Check for the latest
     */

    private function _checkLastCacheTime() {

        $sql = 'SELECT * FROM cache WHERE api_name=:api_name ORDER BY created DESC';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(
            ':api_name' => $this->api_name
        ));
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchCachedData($type) {

        $sql = 'SELECT * FROM cache WHERE created >= :cache_time AND api_name=:api_name ORDER BY created DESC LIMIT 1';

        /*echo $this->cache_threshold.'<br />';
        echo $this->comp_time.'<br />';
        echo $this->comp_time - $this->cache_length.'<br />';
        echo $this->cache_length.'<br />';


        if($this->comp_time){

        }*/

        echo 'SELECT * FROM cache WHERE created >= '.$this->cache_threshold.' AND api_name="'.$this->api_name.'" ORDER BY pub_date ASC';
        #exit();
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(
            ':api_name' => '"'.$this->api_name.'"',
            ':cache_time' => $this->cache_threshold
        ));

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->debug($rows);
        if (!empty($rows)) {

            return $rows;
        } else {

            return false;
        }
    }

    public function saveCacheData($feed, $type) {

        $this->debug($feed);
        switch ($this->api_name) {
            case 'instagram':
                return $this->_saveInstagram($feed, $type);
                break;
        }
    }

    private function _saveInstagram($feed, $type) {

        $data = json_decode($feed);

        $sql = 'INSERT INTO cache (api_name, type, created, pub_date, data) values (:api_name, :type, :created, :pub_date, :data)';

        foreach ($data->data as $item) {

            try {
                $q = $this->pdo->prepare($sql);

                $q->bindParam(':api_name', $this->api_name);
                $q->bindParam(':type', $type);
                $q->bindParam(':created', time());
                $q->bindParam(':pub_date', $item->created_time);
                $q->bindParam(':data', serialize($item));

                $q->execute();
            }catch (PDOException $e) {
                print $e->getMessage() . '<br />';
            }
        }
        //$sql = 'INSERT INTO cache () VALUES'
    }

    function debug($a) {
        echo '<pre>' . print_r($a, true) . '</pre>';
    }

}

?>
