<?php
session_start();
include_once("./Config/dbconfig.php");

class Crud
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

    public
    function sanitize($var)
    {
        $var = trim($var);
        $var = htmlspecialchars($var);
        $var = stripslashes($var);
        $res = mysqli_real_escape_string($this->db, $var);
        return $res;
    }

    public
    function create($fname,$lname,$email,$gender,$language){
        
        $sql1 = "INSERT INTO crud (first_name, last_name, email_id, gender, language) VALUES ('$fname', '$lname', '$email', '$gender', '$language')";
        $res = $this->db->query($sql1) or die(mysqli_connect_error() . "Data cannot inserted");
        if($res){
            $this->msg_success = "Create employee successful!";
            $_SESSION["msg_success"] = $this->msg_success;
            return true;
        }else{
            return false;
        }
    }

    public
    function read(){
        $sql2 = "select * from crud";
        $res = $this->db->query($sql2);
        return $res;
    }

    public
    function read_id($id=NULL){
        $sql3 = "select * from crud";
        if ($id) {
            $sql3 .= " where id='$id'";
    }
        $res = $this->db->query($sql3);
        return $res;
    }
    public
    function update($fname,$lname,$email,$gender,$language, $id) {
        $sql4 = "update crud set first_name='$fname', last_name='$lname', email_id='$email', gender='$gender', language='$language' where id=$id";
        $res = $this->db->query($sql4);
        if($res){
            $this->msg_success = "Update employee successfully!";
            $_SESSION["msg_success"] = $this->msg_success;
            return true;
        }
        else{
            return false;
        }
    }
    public
    function delete($id){
        $sql5 = "delete from crud where id=$id";
        $res = $this->db->query($sql5);
        if($res){
            $this->msg_success = "Delete employee successfully!";
            $_SESSION["msg_success"] = $this->msg_success;
            return true;
        }else{
            return false;
        }
    }

}

?>