<?php
# made by munsiwoo
class User extends SQLite3 {
    function __construct() {
        parent::__construct(__DB__);
    }

    public function login($data) {
        $username = anti_sqlite_inject($data['username']);
        $password = process_password($data['password']);
        $retval = ['status' => false];
        
        $query = "SELECT * FROM mun_users WHERE username='{$username}' AND password='{$password}';";
        $result = $this->query($query);
        $fetch = $result->fetchArray(SQLITE3_ASSOC);

        if($fetch['username']) {
            if($fetch['username'] === __ADMIN__) {
                $_SESSION['admin'] = true; // $is_admin
            }
            $_SESSION['username'] = $fetch['username']; // $is_login
            $_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];

            $retval['msg'] = "Hello, {$fetch['username']}";
            $retval['status'] = true;
        }
        else {
            $retval['msg'] = "Login failed.";
        }

        return json_encode($retval);
    }

    public function register($data) {

        $username = anti_sqlite_inject(mb_substr($data['username'], 0, 30));
        $password = process_password($data['password']);
        $retval = ['status' => false];

        if(preg_match('/[^\w\sㄱ-힣_\-+]+/mis', $username)) { // check username
            $retval['msg']  = 'Allowed range :'.PHP_EOL; 
            $retval['msg'] .= 'alphabet, number, hangul, whitespace, _, -, +';
            return json_encode($retval);
        }

        if(mb_strlen($data['password']) < 5) {
            $retval['msg'] = 'Your password is too short. (more than 5digits)';
            return json_encode($retval);
        }

        $result = $this->query("SELECT * FROM mun_users WHERE username='{$username}';");
        if($result->fetchArray(SQLITE3_ASSOC)) {
            $retval['msg'] = 'Already exists username!';
            return json_encode($retval);
        }

        $this->query("INSERT INTO mun_users VALUES ('{$username}', '{$password}', datetime());");
        $retval['msg'] = 'Registration completed.';
        $retval['status'] = true;
        
        return json_encode($retval);
    }


}
