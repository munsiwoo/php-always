<?php
# made by munsiwoo
class Render extends SQLite3 {
	function __construct() {
		parent::__construct(__DB__);
	}

	public function render_template($page) {
		$file = $_SERVER['DOCUMENT_ROOT'].'/templates/'.$page.'.html';
		$html = file_get_contents($file);

		switch($page) {
			case 'header' :
				$html = str_replace('{MENU}', $this->menu_loader(), $html);
				break;
			case 'mypage' :
				$fetch = array_map('htmlspecialchars', $this->mypage_loader($_SESSION['username'])); 
				$html = str_replace('{USERNAME}', $fetch['username'], $html);
				$html = str_replace('{PASSWORD}', $fetch['password'], $html);
				break;
			default :
				break;
		}

		echo preg_replace('/\n+|\t+|\s{2}/', '', $html); // render
	}

	private function menu_loader() {
		$menu_list = isset($_SESSION['username']) ? 
		['home'=>'/home', 'mypage'=>'/mypage', 'logout'=>'/logout'] :
		['home'=>'/home', 'login'=>'/login', 'register'=>'/register'];

		if(isset($_SESSION['admin'])) {
			$menu_list = ['home'=>'/home', 'admin'=>'/admin', 'mypage'=>'/mypage', 'logout'=>'/logout'];
		}

		$result  = '<table><tr>';
		foreach($menu_list as $menu=>$url) {
			$result .= '<td style="padding-right: 15px;">'.
			"<a href=\"{$url}\" style=\"font-size:30px;\">{$menu}</a></td>";
		}
		$result .= '</tr></table>';

		return $result;
	}

	private function mypage_loader($username) {
		$username = anti_sqli($username);
		$query = $this->query("SELECT * FROM `users` WHERE `username`='{$username}';");
		return $query->fetchArray();
	}

}
