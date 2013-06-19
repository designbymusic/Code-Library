<?php
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
 if( isset($_REQUEST['file']) ){
  $file = $_REQUEST['file'];
  if( goodfile($file) ){
   $ext = end(explode(".", $file));
   switch($ext){
     case 'css':$contenttype = 'css';break;
     case 'js':$contenttype = 'javascript';break;
     default:die();break;
   }
  header('Content-type: text/'.$contenttype.'; charset: UTF-8');
  header ("cache-control: must-revalidate");
  $offset = 60 * 60;
  $expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
  header ($expire);
  $data = file_get_contents($file);
  $data = compress($data);
  echo $data;
  }
 }
exit;

function goodfile($file){
 $invalidChars=array("\\","\"",";",">","<",".php");
 $file=str_replace($invalidChars,"",$file);
 if( file_exists($file) ) return true;
 return false;
}

function compress($buffer) {
 $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
 $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
 return $buffer;
}
?>