<?php
class apiFileCache{

    private $cache_path;

    public function __construct($api_name,$type,$cache_length, $cache_path){

        $this->cache_file   = $_SERVER['DOCUMENT_ROOT'].DS.$cache_path.DS.$api_name.'.'.$type.'.cache';
        $this->cache_length = $cache_length;
    }

    public function fetchCacheData(){
        if(file_exists($this->cache_file) && filemtime($this->cache_file) > time() - $this->cache_length){
            return file_get_contents($this->cache_file);
        }else{
            return false;
        }
    }
    public function writeCacheData($feed){
        file_put_contents($this->cache_file,$feed);
    }
}