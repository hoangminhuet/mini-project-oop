<?php

include_once("./Config/dbconfig.php");

class User
{
    public $db;
    public $msg_success;

    public
    function __construct()
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        mysqli_set_charset($this->db, "UTF8");
        if (mysqli_connect_errno()) {
            echo "Error: Could not connect to database.";
            exit;
        }
    }

    // Registration function
    public
    function register(
        $username,
        $password,
        $name,
        $email
    ) {
        $password = md5($password);
        $sql = "select * from users where uname='$username' or uemail='$email'";
        $check = $this->db->query($sql);
        $count_row = $check->num_rows;
        if ($count_row == 0) {
            $sql1 = "Insert into users (uname, upass, fullname, uemail) values ('$username','$password','$name','$email')";
            $result = $this->db->query($sql1) or die(mysqli_connect_error() . "Data cannot inserted");
            $this->msg_success = "After registering successfully, you can login using your account!";
            $_SESSION["msg_success"] = $this->msg_success;
            return $result;
        } else {
            return false;
        }
    }

    //Check login function

    public
    function check_login(
        $emailusername,
        $password
    ) {
        if (isset($_POST["submit"])) {
            $password = md5($password);
            $sql2 = "Select * from users where uemail='$emailusername' or uname='$emailusername' and upass='$password'";
            $result = $this->db->query($sql2);
            $data = mysqli_fetch_array($result);
            $count_row = $result->num_rows;
            if ($count_row == 1) {
                $_SESSION["user"] = $emailusername;
                $_SESSION['login'] = true;
                $_SESSION["uid"] = $data["uid"];

                if (!empty($_POST["remember"])) {
                    $hour = time() + 3600*24*30;
                    setcookie("user_login", $_POST["emailusername"], $hour);
                    setcookie("pass_login", md5($_POST["password"]), $hour);
                } else {
                    if (isset($_COOKIE["user_login"])) {
                        setcookie("user_login", "", time()-$hour);
                    }
                    if (isset($_COOKIE["pass_login"])) {
                        setcookie("pass_login", "", time()-$hour);
                    }
                }
                header("location:index.php");
            } else {
                $this->msg_success = "Invalid login";
            }
        }

    }

    public
    function get_fullname(
        $uid
    ) {
        $sql3 = "select fullname from users where uid='$uid'";
        $result = $this->db->query($sql3);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['fullname'];
    }

    public

    function get_session()
    {
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        }
    }

    public

    function user_logout()
    {
        $_SESSION['login'] = false;
        $hour = time() - 3600;
        setcookie("user_login", "", $hour);
        setcookie("pass_login", "", $hour);
        session_destroy();
    }
}


?>