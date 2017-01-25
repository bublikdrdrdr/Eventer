<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Bublik
 */
class Login {

    //put your code here

    public  $db;
    
    private $session_id;

    public function __construct() {
        include 'DB.php';
        include_once 'SQLconnect.php';
        $this->db = new DB(SQLconnect::server, SQLconnect::user, SQLconnect::pass, SQLconnect::db);
        // echo '<h1>user ID=  '.$this->getLoggedUserId().'</h1>';
    }

    private function getSession() {
     if (session_status() != PHP_SESSION_ACTIVE)
     {
           session_start();
     }
     return session_id();
    }

    public function getLoggedUserId() {
        $sid = $this->getSession();
        $sql = "SELECT l.id_user FROM logged_users l WHERE l.session_id = '" . $sid . "'";
        $id = $this->db->selectOne($sql, "id_user");
        return $id;
    }

    public function logout() {
        $sid = $this->getSession(); 
        $sql = "DELETE FROM logged_users WHERE session_id = '" . $sid . "'";
        $dl = $this->db->delete($sql);
    }

    public function logoutFromAll($user_id) {
        $sql = "DELETE FROM logged_users l WHERE l.id_user = '" . $user_id . "'";
        $this->db->delete($sql);
    }
    
    public function getAllEvents()
    {
        $sql = "SELECT DISTINCT e.id_event FROM events e";
        $arr = $this->db->select($sql, array("id_event"));
        return $arr;
    }
    
    public function getMyEvents()
    {
        $idd = $this->getLoggedUserId();
        $sql = "SELECT DISTINCT e.id_event FROM events e where e.id_author = ".$idd;
       // echo $sql;
        $arr = $this->db->select($sql, array("id_event"));
        return $arr;
    }


    public static function hashPass($password) {
        return hash("sha256", $password);
    }
    
    public function getNickname($id)
    {
        $sql = "SELECT u.nickname FROM users u WHERE u.id_user = $id";
        return $this->db->selectOne($sql, "nickname");
    }

    public function getLoggedUserNickname() {
        $uid = $this->getLoggedUserId();
        $sql = "SELECT u.nickname FROM users u WHERE u.id_user = $uid";
        return $this->db->selectOne($sql, "nickname");
    }
    
    public function checkPass($id, $pass)
    {
        $npass = Login::hashPass($pass);
        $sql = "SELECT u.id_user FROM users u WHERE u.id_user = '" . $id . "' and u.password = '" . $npass . "'";
        $uid = $this->db->selectOne($sql, "id_user");
        if ($uid == NULL) {
            return false;
        } else
        {
            return true;
        }
    }
    
    public function updateInfo($id, $name, $surname, $email, $password)
    {
        $cpass = Login::hashPass($password);
        $sql = "UPDATE `users` SET `name` = '".$name."', `surname` = '".$surname."', `password` = '".$cpass."', `email` = '".$email."' WHERE `users`.`id_user` = ".$id.";";
        $this->db->insert($sql);
    }
    
    public function getUserData($id)
    {
        $sql = "SELECT u.name, u.surname, u.email FROM users u WHERE u.id_user = ".$id;
        return $this->db->select($sql, array("name", "surname", "email"));
    }

    public function login($login, $password) {
        $Clogin = htmlspecialchars($login);
        $Cpassword = $this->hashPass($password);
       // echo "$Cpassword";

        if ($this->getLoggedUserId() != NULL) {
            $this->logout();
        }

        $sql = "SELECT u.id_user FROM users u WHERE u.email = '" . $Clogin . "' and u.password = '" . $Cpassword . "'";
        $uid = $this->db->selectOne($sql, "id_user");
        if ($uid == NULL) {
            return NULL;
        }
        $sid = $this->getSession();
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `logged_users` (`id_logged_user`, `id_user`, `last_login`, `session_id`) "
                . "VALUES (NULL, '" . $uid . "', '" . $date . "', '" . $sid . "');";
        if ($this->db->insert($sql) == true) {
            return $uid;
        } else {
            return NULL;
        }
    }

    const NICKNAME_ALREADY_REGISTERED = 20;
    const EMAIL_ALREADY_REGISTERED = 21;
    const REGISTRATION_IS_DONE = 22;
    const SQL_QUERY_ERROR = 23;

    public function checkEmail($email) {
        if ($this->checkData($email, "email")==false)
        {
            return FALSE;
        }
        $sql = "SELECT u.id_user FROM users u WHERE lower(u.email) = '" . $email . "'";
        if ($this->db->count($sql) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkNickname($nickname) {
        if ($this->checkData($email, "nickname")==false)
        {
            return FALSE;
        }
        $sql = "SELECT u.id_user FROM users u WHERE lower(u.nickname) = '" . $nickname . "'";
        if ($this->db->count($sql) > 0) {
            return false;
        } else {
            return true;
        }
    }
    


    public function checkData($data, $type)
    {
        switch ($type)
        {
            case "email": 
                return preg_match("/[^\/,'`]{0,}[@]{1}[^\/,'`]{0,}/", $data);
            case "nickname": break;
        }
    }

    public function register($name, $surname, $nickname, $password, $email) {
        if ($this->checkEmail($email) == FALSE) {
            return $this::EMAIL_ALREADY_REGISTERED;
        }
        if ($this->checkNickname($nickname) == FALSE) {
            return $this::NICKNAME_ALREADY_REGISTERED;
        }

        $Cpass = $this->hashPass($password);
        $sql = "SELECT ut.id_type FROM user_types ut WHERE lower(ut.name) like 'user'";
        $type = $this->db->selectOne($sql, "id_type");
       // echo "<br>$type, $name, $surname, $nickname, $Cpass, $email<br>";
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `users` (`id_user`, `id_type`, `name`, `surname`, `nickname`, `password`, `email`, `blocked`, `registration_date`) 
VALUES (NULL,  '$type',  '$name',  '$surname', '$nickname',  '$Cpass', '$email',  '0', '$date');";
       
        if ($this->db->insert($sql)==false)            
        {
            return $this::SQL_QUERY_ERROR;
        }

        return $this::REGISTRATION_IS_DONE;
    }
    
    public function checkUserData($name, $surname, $email)
    {
        $blad = false;
        if ((!isset($name))||(!isset($surname))||(!isset($email)))
        {
            $blad = true;
        }
        return $blad;
    }
    

}
