<?php
# made by munsiwoo
class Render extends SQLite3 {
    function __construct() {
        parent::__construct(__DB__);
    }

    public function get_top_menu($is_login, $is_admin) { // Render header.html
        $retval = $is_login ? __USER_MENU__ : __GUEST_MENU__;
        if($is_admin)
            $retval['Admin'] = __ADMIN_PAGE__;

        return $retval;
    }

    public function get_board_posts() { // Render board.html
        $query = "SELECT * FROM mun_board ORDER BY no DESC;";
        $result = $this->query($query);
        $retval = [];

        while($fetch = $result->fetchArray(SQLITE3_ASSOC)) {
            $fetch = array_map('htmlspecialchars', $fetch);
            array_push($retval, $fetch);
        }

        return $retval;
    }

    public function get_user_posts($username) { // Render mypage.html
        $username = anti_sqlite_inject($username);
        $result = $this->query("SELECT * FROM mun_board WHERE username='{$username}';");
        $retval = [];

        while($fetch = $result->fetchArray(SQLITE3_ASSOC)) {
            $fetch = array_map('htmlspecialchars', $fetch);
            array_push($retval, $fetch);
        }

        return $retval;
    }

    public function get_post($no, $username) { // Render update.html
        $no = (int)$no;
        $retval = ['status'=>false];

        $result = $this->query("SELECT * FROM mun_board WHERE no='{$no}';");
        $fetch = $result->fetchArray(SQLITE3_ASSOC);

        if($fetch['username'] === $username) {
            $retval['status'] = true;
            $retval['result'] = array_map('htmlspecialchars', $fetch);
            return $retval;
        }

        return $retval;
    }

}
