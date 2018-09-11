<?php
error_reporting(0);
session_start();
# made by munsiwoo

if(empty($_GET['p'])) {
	header('Location: /home');
	exit;
}

require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/function.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Controller.class.php';

if($page = secure_page($_GET['p'])) {
	$method = $_SERVER['REQUEST_METHOD'];
	$is_login = isset($_SESSION['username']);
	$is_admin = isset($_SESSION['admin']);
	new Controller($method, $page, $is_login, $is_admin);
}
else {
	header('HTTP/1.1 404 Not Found', true, 404);
	die('The website is not exist');
}
