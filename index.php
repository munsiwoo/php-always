<?php
error_reporting(0);
# made by munsiwoo

session_name('session_id');
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/function.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Controller.class.php';

$http_method = $_SERVER['REQUEST_METHOD']; // request method
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_login = isset($_SESSION['username']);
$is_admin = isset($_SESSION['admin']);

$Controller = new Controller($http_method, $request_uri, $is_login, $is_admin);