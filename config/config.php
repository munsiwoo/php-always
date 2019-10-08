<?php
error_reporting(0);
# made by munsiwoo

define('__DB__', $_SERVER['DOCUMENT_ROOT'].'/config/mydb.db');
define('__TEMPLATE__', $_SERVER['DOCUMENT_ROOT'].'/templates');

define('__SALT__', sha1('foo'));
define('__TITLE__', 'mvc');
define('__ADMIN__', 'munsiwoo');
define('__DOMAIN__', $_SERVER['HTTP_HOST']);
#define('__DOMAIN__', '127.0.0.1');

define('__USER_MENU__', [
    'Main' => '/',
    'Board' => '/board',
    'Write' => '/write',
    'Mypage' => '/mypage',
    'Logout' => '/logout',
]);

define('__GUEST_MENU__', [
    'Main' => '/',
    'Board' => '/board',
    'Login' => '/login',
    'Register' => '/register',
]);

define('__ADMIN_PAGE__', '/admin');