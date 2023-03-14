<?php
error_reporting(0);
define('USE_DB', (boolean)getenv('USE_DB'));
define('DB_ENV', [
    'host'=> getenv('MYSQL_HOST'),
    'user'=> getenv('MYSQL_USER'),
    'pass'=> getenv('MYSQL_PASS'),
    'name'=> getenv('MYSQL_DB')
]);
define('TEMPLATE_DIR', $_SERVER['DOCUMENT_ROOT'].'/templates');
define('PWD_SALT', getenv('PWD_SALT') ? getenv('PWD_SALT') : 'phpalwaysalt');