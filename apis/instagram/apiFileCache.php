<?php

/**
 * Basic class for writing API response data to a flat file
 * @author Dave Ashman <dash@designbymusic.com>
 */
class apiFileCache {

    private $cache_path;
    private $cache_file;
    private $cache_length = 60;

    public function __construct($api_name, $type, $cache_length, $cache_path) {
        $this->cache_file = $_SERVER['DOCUMENT_ROOT'] . DS . $cache_path . DS . $api_name . '.' . $type . '.cache';
        $this->cache_length = $cache_length;
    }

    /**
     * @desc    Checks if the cache file exists and if so, checks that
     *          it is younger than the cache time. if so, we read it's contents.
     *
     * @return boolean
     */
    public function fetchCacheData() {
        if (file_exists($this->cache_file) && filemtime($this->cache_file) > time() - $this->cache_length) {
            return file_get_contents($this->cache_file);
        } else {
            return false;
        }
    }

    /**
     * @desc    Write the response to the file
     * @param type $feed Object
     */
    public function writeCacheData($feed) {
        $this->_writeData($this->cache_file, 'w', $feed);
    }

    /**
     * @desc Allow retrying a write with flock a set number of times. If it can't flock,
     *       it will sleep for a brief random interval and try again. If you have a lot
     *       of concurrent writes going on, you can use it to avoid data corruption.
     *
     *      http://www.php.net/manual/en/function.flock.php#84824
     *      Read/write modes: http://php.net/manual/en/function.fopen.php
     *
     * @param type $path    Path to cache file
     * @param type $mode    Read/Write mode
     * @param type $data    Object/arry to write to file
     * @return boolean
     *
     */

    private function _writeData($path, $mode, $data) {
        $fp = fopen($path, $mode);
        $retries = 0;
        $max_retries = 100;

        if (!$fp) {
            // failure
            return false;
        }

        // keep trying to get a lock as long as possible
        do {
            if ($retries > 0) {
                usleep(rand(1, 10000));
            }
            $retries += 1;
        } while (!flock($fp, LOCK_EX) and $retries <= $max_retries);

        // couldn't get the lock, give up
        if ($retries == $max_retries) {
            // failure
            return false;
        }

        // got the lock, write the data
        fwrite($fp, $data);
        // release the lock
        flock($fp, LOCK_UN);
        fclose($fp);
        // success
        return true;
    }
}
