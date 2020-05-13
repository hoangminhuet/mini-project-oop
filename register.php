<?php
session_start();
include_once('./Classes/User.php');
$user = new User();
if (isset($_REQUEST["register"])) {
    extract($_REQUEST);
    if (empty($username)) {
        $msg_error = "Please enter username!";
    }
    if (empty($email)) {
        $msg_error = "Please enter email!";
    }
    if (empty($name)) {
        $msg_error = "Please enter name!";
    }
    if (empty($password)) {
        $msg_error = "Please enter password!";
    }
    if (!empty($name) && !empty($username) && !empty($email) && !empty($password)) {
        $register = $user->register($username, $password, $name, $email);
        if ($register) {
            header("location:login.php");
        } else {
            $msg_error = "Something went wrong. Please try again!";
        }
    } else {
        $msg_error = "Please enter your details!";
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <title>Registration</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<div class="container">
    <form action="" method="post">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary" style="margin-top: 125px">
                <div class="panel-body">
                    <h1 class="text-center text-info">Register Here</h1>
                    <?php
                    if (isset($msg_error)) {
                        ?>
                        <div class="alert alert-danger">
                            <strong>Error!</strong> <?php echo $msg_error; ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Please enter name...">
                    </div>

                    <div class="form-group">
                        <label for="user-name">Username:</label>
                        <input type="text" class="form-control" name="username" placeholder="Please Enter Username..."
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="email" placeholder="Please enter email..."
                        >
                    </div>

                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" name="password"
                               placeholder="Please Enter Password...">
                    </div>

                    <button type="submit" class="btn btn-lg btn-success btn-block" name="register">Register
                    </button>

                    <div style="text-align: center;"><b>Already Registered?</b> <br></b><a href="login.php">Click
                            here!</a></div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
