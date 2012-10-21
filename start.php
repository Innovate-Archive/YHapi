<?php

function GetBetween($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
}
$tmp_fname = tempnam("/tmp", "COOKIE");
    $output=file_get_contents("http://www.youhosting.com/en/auth");
    $output=GetBetween($output,"document.write(",");");
    $delete=array('"',"'","+","<",">"," ","=",'i','n','p','u','t','a','m','e','h','d','v','l','w','r','o','c','k','s','y');
    $key=str_replace($delete,"",$output);

$curl_handle = curl_init ("http://www.youhosting.com/en/auth");
 
    curl_setopt ($curl_handle, CURLOPT_COOKIEJAR, $tmp_fname);
	curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, true);
 
	$post_array = array('submit'=>'Login', 'email' => 'staff@rocketserve.net/maarten', 'password' => 'fixmyissue1', 'wristlocks'=>$key);
 
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_array);
 
	$output = curl_exec ($curl_handle);
 
	$curl_handle = curl_init ("http://www.youhosting.com/");
	curl_setopt ($curl_handle, CURLOPT_COOKIEFILE, $tmp_fname);
	curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, true);
 
	$output = curl_exec ($curl_handle);
 
    $output=GetBetween($output,'<a href="/en/client">','</a>');
    echo 'Number of clients: ';
	echo $output;
    echo '<br>The first YH api! CC-BY Maarten Eyskens';