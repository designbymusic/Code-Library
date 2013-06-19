<?php
date_default_timezone_set('Europe/London');
DEFINE('MYSQL_HOST', '127.0.0.1');
DEFINE('MYSQL_USER', 'root');
DEFINE('MYSQL_DB', 'sandbox_localhost');
DEFINE('MYSQL_PASS', 'password');
defined('DS') or define('DS',DIRECTORY_SEPARATOR);

function __autoload($name) {
    echo "Want to load $name.\n";
    try{
        include_once($name.'.php');
    }catch(Exception $e){
        throw new Exception("Unable to load $name.");
    }
}
?>
