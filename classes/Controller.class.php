<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Render.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Board.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/MunTemplate.class.php';
# made by munsiwoo

class Controller {
    function __construct($http_method, $request_uri, $is_login, $is_admin) {
        $User = new User();
        $Render = new Render();
        $Board = new Board();
        $MunTemplate = new MunTemplate(__TEMPLATE__);

        /*
        Remove the this comment if you need CSRF mitigation.
        And set __DOMAIN__ in /config/config.php
    
        if($http_method == 'POST') { // CSRF mitigation
            $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            if($referer !== __DOMAIN__) die('Not allowed referer!');
        } */


        /*
        Remove the this comment if you need XSS mitigation. 

        if($is_login && $_SESSION['userip'] !== $_SERVER['REMOTE_ADDR']) { // Session hijacking and XSS mitigation
            session_destroy();
            redirect_url("/", "IP has changed!\nPlease login again");
        } */

        if($http_method == 'GET') { // Load header
            $top_menu = $Render->get_top_menu($is_login, $is_admin);
            $MunTemplate->render_template('header.html', ['top_menu'=>$top_menu]);
        }

        switch($request_uri) { // Simple router
            case '/' :
                if($is_login)
                    $msg = 'Hello, '.htmlspecialchars($_SESSION['username']);
                else
                    $msg = 'This is index.html';

                $MunTemplate->render_template('index.html', ['msg'=>$msg]);
                break;

            case '/logout' :
                session_destroy();
                redirect_url('/');
                break;

            case '/login' :
                if($http_method == 'POST') {
                    echo $User->user_login($_POST);
                    break;
                }
                $MunTemplate->render_template('login.html');
                break;

            case '/register' :
                if($http_method == 'POST') {
                    echo $User->user_register($_POST);
                    break;
                }
                $MunTemplate->render_template('register.html');
                break;

            case '/board' :
                $posts = $Render->get_board_posts(); // Get all posts
                $MunTemplate->render_template('board.html', ['posts'=>$posts]);
                break;

            case '/mypage' :
                if(!$is_login)
                    redirect_url("/login", "Please login!");
                $username = htmlspecialchars($_SESSION['username']);
                $posts = $Render->get_user_posts($_SESSION['username']); // Get all posts of user
                $MunTemplate->render_template('mypage.html', ['username'=>$username, 'posts'=>$posts]);            
                break;

            case '/write' :
                if(!$is_login)
                    redirect_url("/login", "Please login!");
                if($http_method == 'POST') {
                    echo $Board->write($_POST);
                    break;
                }
                $MunTemplate->render_template('write.html');
                break;

            case '/read' :
                if(!$_GET['no'])
                    redirect_url("/board", "It's a wrong approach.");
                $post = $Board->read($_GET);
                if($post['status']) {
                    $is_mypost = ($post['result']['username'] === $_SESSION['username']); // For visible "Delete", "Update" buttons
                    $MunTemplate->render_template('read.html', ['is_mypost'=>$is_mypost, 'post'=>$post['result']]);
                }
                else
                    redirect_url("/board", "It's a wrong approach.");
                break;

            case '/update' :
                if(!$is_login)
                    redirect_url("/login", "Please login!");
                if($http_method == 'POST') {
                    echo $Board->update($_POST);
                    break;
                }

                if(!$_GET['no'])
                    redirect_url("/board", "It's a wrong approach.");

                $post = $Render->get_post($_GET['no'], $_SESSION['username']); // Get the posts you want to update.
                if($post['status'])
                    $MunTemplate->render_template('update.html', ['post'=>$post['result']]);
                else 
                    redirect_url("/board", "It's a wrong approach.");
                break;

            case '/delete' :
                if(!$is_login)
                    redirect_url("/login", "Please login!");
                if($http_method == 'POST') {
                    echo $Board->delete($_POST);
                    break;
                }
                break;


            /* admin pages */

            case '/admin' :
                if(!$is_login)
                    redirect_url("/login", "Please login!");
                if(!$is_admin)
                    redirect_url("/", "You are not admin!");
                $MunTemplate->render_template('admin.html');
                break;
                
            default :
                header("HTTP/1.1 404 Not Found");
                echo '<br><img src="/static/img/404.png" style="width: 500px; height: auto;">';
        }

        if($http_method == 'GET') { // load footer
            $MunTemplate->render_template('footer.html');
        }
    }
}
