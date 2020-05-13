<?php
session_start();
include_once('./Classes/User.php');
$user = new User();

if (isset($_REQUEST['submit'])) {
    extract($_REQUEST);

    if (isset($_COOKIE["user_login"]) && isset($_COOKIE["pass_login"])) {
        $acc = $_COOKIE["user_login"];
        $pass = $_COOKIE["pass_login"];
        $sql2 = "Select * from users where uemail='$acc' or uname='$acc' and upass='$pass'";
        $result = $user->db->query($sql2);
        $data = mysqli_fetch_array($result);
        if ($result != false) {
            $_SESSION["user"] = $emailusername;
            $_SESSION['login'] = true;
            $_SESSION["uid"] = $data["uid"];
            header("location:index.php");
            exit();
        }
    } else {
        header("location:login.php");
        $login = $user->check_login($emailusername, $password);
        if (empty($emailusername)) {
            $msg_error = "Please enter username or email!";
        } else {
            if (empty($password)) {
                $msg_error = "Please enter password!";
            } else {
                if ($login) {
                    // Registration Success
                    header("location:index.php");
                } else {
                    // Registration Failed
                    $msg_error = "Please check your username, email or password!";
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<head lang="en">
    <title>Login Module</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
    .login-panel {
        margin-top: 150px;
</style>

<body>
<div class="container">
    <?php
    if (isset($_SESSION["msg_success"])) {
        ?>
        <div class="alert alert-success">
            <strong>Success!</strong> <?php echo $_SESSION["msg_success"]; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php
        unset($_SESSION["msg_success"]);
    } ?>
    <form action="" method="post">
        <div class="col-md-6 col-md-offset-3">
            <div class="login-panel panel panel-primary">
                <div class="panel-body">
                    <h1 class="text-center text-info">Login Here</h1>

                    <?php
                    if (isset($msg_error)) {
                        ?>
                        <div class="alert alert-danger">
                            <strong>Error!</strong> <?php echo $msg_error; ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="username">Username or email:</label>
                        <input type="text" class="form-control" name="emailusername"
                               value="" placeholder="Nhập tài khoản...">
                    </div>

                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" name="password"
                               value="" placeholder="Nhập mật khẩu...">
                    </div>
                    <div class="form-group">
                        <div style="text-align: center;">
                            <input type="checkbox" name="remember"
                                   id="remember" <?php if (isset($_COOKIE["user_login"])) { ?> checked <?php } ?> />
                            <label for="remember-me">Remember me</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-success btn-block" name="submit">Login</button>
                    <div style="text-align: center;"><b>Do not have an account?</b> <br></b><a href="register.php">Register
                            new user</a></div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
