<?php

function d($a){
	echo '<pre style="font-family:\'Lucida Console\';font-size: 12px;padding: 20px;background: #fc0">'.print_r($a, true).'</pre>';
}

function obfuscateEmail($address){
	$link = 'mailto:' . $address;
     $obfuscatedLink = "";
     for ($i=0; $i<strlen($link); $i++){
         $obfuscatedLink .= "&#" . ord($link[$i]) . ";";
     }
     return  $obfuscatedLink;
}

