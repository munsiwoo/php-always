<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/MunTemplate.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';

class Controller{
    function __construct(){
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->request_uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        if(isset($_SERVER['CONTENT_TYPE'])){
            if(strpos($_SERVER['CONTENT_TYPE'], 'application/json') === 0)
                $this->body = json_decode(file_get_contents('php://input'), true);
            if(strpos($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded') === 0)
                $this->body = $_POST;
            if(strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') === 0){ // file upload
                $this->body = $_POST;
                $this->files = $_FILES;
            }
        } else {
            $this->body = json_decode(file_get_contents('php://input'), true); // default json
        }
        $this->route();
    }
    function route(){
        $User = new User();
        $MunTemplate = new MunTemplate(TEMPLATE_DIR);
        
        switch($this->request_uri){
            case '/':
                check_login(true);
                $MunTemplate->render_template('main.html');
                break;

            case '/register':
                $MunTemplate->render_template('register.html');
                break;

            case '/login':
                $MunTemplate->render_template('login.html');
                break;

            case '/api/v1/login': // User sign in
                allow_method(['POST']);
                echo $User->login($this->body);
                break;

            case '/api/v1/register': // User sign up
                allow_method(['POST']);
                echo $User->register($this->body);
                break;

            case '/robots.txt':
                header('Content-Type: text/plain');
                $MunTemplate->render_template('robots.txt');
                break;

            default :
                header('HTTP/1.1 404 Not Found');
                echo 'Not found';
        }
    }
}