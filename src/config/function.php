<?php
function redirect_url($url, $msg=""){ // redirect function
    header('Location: '.$url);
    $execute  = "<script>location.href=\"{$url}\";";
    if(strlen($msg))
        $execute .= 'alert("'.str_replace('/', '\\/', addslashes($msg)).'");';
    $execute .= '</script>'; die($execute);
}
function backward_url($msg=""){ // history backward
    $execute  = '<script>history.back();';
    if(strlen($msg))
        $execute .= 'alert("'.str_replace('/', '\\/', addslashes($msg)).'");';
    $execute .= '</script>'; die($execute);
}
function password_hashing($password){
    return hash('sha256', sha1(sha1(md5($password).PWD_SALT)).PWD_SALT);
}
function allow_method($allowed_method){
    $method = $_SERVER['REQUEST_METHOD'];
    $allow = true;
    if(is_string($allowed_method)) // typeof $allowed_method == String  (exam: 'GET')
        if($method !== $allowed_method) $allow = false;
    else if(is_array($allowed_method)) // typeof $allowed_method == Array (exam: ['GET', 'POST'])
        if(!in_array($method, $allowed_method)) $allow = false;
    else
        $allow = false;
    if(!$allow){
        header('HTTP/1.1 405 Method Not Allowed');
        die('<h1>405 Method Not Allowed</h1>');
    }
    return true;
}
function check_login($redirect=False){
    if(!isset($_SESSION['userid']))
    if($redirect)
        redirect_url('/login');
    else
        die('unauthorized');
    return true;
}
function check_admin(){
    if(!isset($_SESSION['is_admin']))
        die('unauthorized');
}
function fetch_api($method, $uri, $data=[], $headers=['Content-Type: application/json']){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if(strtoupper($method) == 'POST'){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $response = curl_exec($ch);
    curl_close($ch);
    $retval = json_decode($response, true);
    return $retval;
}