<?php
error_reporting(0);
# made by munsiwoo

function redirect_url($url, $msg="") { // redirect function
    $execute  = "<script>location.href=\"{$url}\";";
    $execute .= strlen($msg) ? 'alert("'.addslashes($msg).'");' : '';
    $execute .= '</script>'; die($execute);
}

function backward_url($msg="") { // history backward
    $execute  = '<script>history.back();';
    $execute .= strlen($msg) ? 'alert("'.addslashes($msg).'");' : '';
    $execute .= '</script>'; die($execute);
}

function process_password($password) {
    return md5(hash('sha256', sha1(md5($password).__SALT__)));
}

function anti_sqlite_inject($argv) {
    return str_replace("'", "''", $argv);
}
