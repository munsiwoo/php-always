<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Render.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';
# made by munsiwoo

class Controller {
	function __construct($method, $page, $is_login, $is_admin) {
		$Render = new Render();
		$User = new User();

		if(!$is_login) { // need session
			$scandir = $_SERVER['DOCUMENT_ROOT'].'/templates/need_session/';
			$not_allow_page = array_diff(scandir($scandir), ['.', '..']);
			$not_allow_page = array_map(array($this, 'filename'), $not_allow_page);

			if(in_array($page, $not_allow_page)) {
				header('HTTP/1.1 403 Forbidden', true, 403);
				go('/login', 'please login first.');
			}
		}


		if(!$is_admin) { // need permission
			$scandir = $_SERVER['DOCUMENT_ROOT'].'/templates/need_permission/';
			$not_allow_page = array_diff(scandir($scandir), ['.', '..']);
			$not_allow_page = array_map(array($this, 'filename'), $not_allow_page);
			
			if(in_array($page, $not_allow_page)) {
				header('HTTP/1.1 403 Forbidden', true, 403);
				go('/home', 'you are not admin.');
			}
		}


		if($page == 'logout') { // logout
			session_destroy();
			go('/home', 'logout success');
		}

		else if($method == 'POST') { // POST
			switch($page) { // route
				case 'login' :
					$User->login($_POST);
					break;
				case 'register' :
					$User->register($_POST);
					break;
				default :
					break;
			}

		}

		else { // GET
			$Render->render_template('header');
			$Render->render_template($page);
			$Render->render_template('footer');
		}
	}

	public function filename($name) {
		return pathinfo($name)['filename'];
	}
}
