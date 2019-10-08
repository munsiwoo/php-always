<?php
# made by munsiwoo
class Board extends SQLite3 {
	function __construct() {
		parent::__construct(__DB__);
	}

    private function is_writer($no, $username) {
        $result = $this->query("SELECT username FROM mun_board WHERE no='{$no}';");
        $writer = $result->fetchArray(SQLITE3_NUM)[0];

        if($writer === $username)
            return true;
    
        return false;
    }

    public function write($data) {
        $data = array_map('anti_sqlite_inject', $data);
        $retval = ['status' => false, 'msg' => 'Write failed.'];

        $title = substr($data['title'], 0, 35);
        $contents = $data['contents'];
        $username = anti_sqlite_inject($_SESSION['username']);

        $query = "INSERT INTO mun_board VALUES (NULL, '{$title}', '{$contents}', '{$username}', datetime());";
        if($this->query($query)) {
            $last_id = $this->query("SELECT last_insert_rowid();")->fetchArray(SQLITE3_NUM)[0];
            $retval['rurl'] = "/read?no={$last_id}";
            $retval['msg'] = 'Write success.';
            $retval['status'] = true;
        }

        return json_encode($retval);
    }

    public function read($data) {
        $no = (int)$data['no'];
        $retval = ['status' => false];
        $result = $this->query("SELECT * FROM mun_board WHERE no='{$no}';");
        
        if($fetch = $result->fetchArray(SQLITE3_ASSOC)) {
            $retval['status'] = true;
            $retval['result'] = array_map('htmlspecialchars', $fetch);
        }

        return $retval;
    }

    public function delete($data) {
        $no = (int)$data['no'];
        $username = anti_sqlite_inject($_SESSION['username']);    
        $retval = ['status' => false];

        if(!$this->is_writer($no, $username))
            return json_encode($retval);

        $query = "DELETE FROM mun_board WHERE no='{$no}' AND username='{$username}';";
        if($this->query($query))
            $retval['status'] = true;
        
        return json_encode($retval);
    }

    public function update($data) {
        $data = array_map('anti_sqlite_inject', $data);
        $retval = ['status' => false, 'msg' => 'Update failed.'];

        $no = (int)$data['no'];
        $title = $data['title'];
        $contents = $data['contents'];
        $username = anti_sqlite_inject($_SESSION['username']);

        if(!$this->is_writer($no, $username))
            return json_encode($retval);

        $query = "UPDATE mun_board SET title='{$title}', contents='{$contents}' WHERE no='{$no}' AND username='{$username}';";
        if($this->query($query)) {
            $retval['msg'] = 'Update success.';
            $retval['rurl'] = "/read?no={$no}";
            $retval['status'] = true;
        }

        return json_encode($retval);
    }

}
