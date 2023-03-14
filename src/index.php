<?php
error_reporting(0);
session_name('session');
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/config/env.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/function.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Controller.class.php';

new Controller();