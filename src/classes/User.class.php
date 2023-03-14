<?php
class User{
    function __construct(){
        if(USE_DB){
            extract(DB_ENV);
            $this->db = new PDO("mysql:host={$host};dbname={$name};charset=UTF8", $user, $pass);
        }
    }
    function login($data){
        $userid = $data['userid'];
        $password = password_hashing($data['password']);
        $retval = ['status' => false];
    
        $sth = $this->db->prepare('SELECT * FROM users WHERE userid=? AND password=?');
        $sth->execute([$userid, $password]);

        if($fetch = $sth->fetch(PDO::FETCH_ASSOC)){
            $retval['status'] = true;
            $retval['message'] = 'You have successfully logged in.';
            $_SESSION['userid'] = $fetch['userid'];

            if($fetch['is_admin']) $_SESSION['is_admin'] = 1;
        } else {
            $retval['message'] = 'The username or password doesn\'t match.';
        }
        header('Content-Type: application/json');
        return json_encode($retval);
    }
    function register($data){
        header('Content-Type: application/json');
        $retval = ['status' => false];
        
        $userid = mb_strlen($data['userid']) ? trim(mb_substr($data['userid'], 0, 64)) : NULL;
        $password = password_hashing($data['password']);

        if(is_null($userid)){
            $retval['message'] = 'The username is invalid.';
            return json_encode($retval);
        }
        if(mb_strlen($data['password']) < 7){
            $retval['message'] = 'Please set your password to at least 8 characters.';
            return json_encode($retval);
        }
        $sth = $this->db->prepare("SELECT * FROM users WHERE userid=?");
        $sth->execute([$userid]);
        if($sth->fetch(PDO::FETCH_ASSOC)){
            $retval['message'] = 'A user that already exists.';
        }
        else {
            $query = "INSERT INTO users (`userid`, `password`, `create_at`, `is_admin`) VALUES (?, ?, now(), 0)";
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->execute([$userid, $password]);

            $this->db->commit();
            $retval['status'] = true;
            $retval['message'] = 'You have successfully signed up.';
        }
        return json_encode($retval);
    }
}
