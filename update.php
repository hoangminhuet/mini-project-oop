<?php

include_once("./Classes/Crud.php");

$crud = new Crud();
if (isset($_REQUEST["update"])) {
    extract($_REQUEST);
    $fname = $crud->sanitize($_POST["fname"]);
    $lname = $crud->sanitize($_POST["lname"]);
    $email = $crud->sanitize($_POST["email"]);
    $gender = $_POST["gender"];
    $language = $_POST["language"];
    if (empty($fname) || empty($lname) || empty($email) || empty($gender) || empty($language))
    {
            $msg_error = "Please check your information again!";
    }
    else {
        $result = $crud->update($fname, $lname, $email, $gender, $language, $id);
        if ($result){
            header("location:index.php");
        }
        else {
            $msg_error = "Something went wrong. Please try again";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Employees</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <?php
        if (isset($_GET["id"])) {
            $id = $_GET['id'];
        }
        $res = $crud->read_id($id);
        while ($r = mysqli_fetch_assoc($res)) {
            ?>
            <form action="update.php" method="post" class="form-horizontal col-md-6 col-md-offset-3">
                <div class="page-header">
                    <div style="text-align: center;"><h2>Update <b>Employee</b></h2></div>
                </div>
                <?php
                if (isset($msg_error)) {
                    ?>
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?php echo $msg_error; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="input1" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="fname" class="form-control" id="input1"
                               value="<?php echo $r['first_name'] ?>" placeholder="First Name"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input1" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="lname" class="form-control" id="input1"
                               value="<?php echo $r['last_name'] ?>" placeholder="Last Name"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input1" class="col-sm-2 control-label">E-Mail</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="input1"
                               value="<?php echo $r['email_id'] ?>" placeholder="E-Mail"/>
                    </div>
                </div>

                <div class="form-group" class="radio">
                    <label for="input1" class="col-sm-2 control-label">Gender</label>
                    <div class="col-sm-10">
                        <label>
                            <input type="radio" name="gender" id="optionsRadios1"
                                   value="male" <?php if ($r['gender'] == 'male') {
                                echo "checked";
                            } ?>> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" id="optionsRadios1"
                                   value="female" <?php if ($r['gender'] == 'female') {
                                echo "checked";
                            } ?>> Female
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input1" class="col-sm-2 control-label">Language</label>
                    <div class="col-sm-10">
                        <select name="language" class="form-control">
                            <option>Select Your Language</option>
                            <option value="PHP" <?php if ($r['language'] == 'PHP') {
                                echo "selected";
                            } ?>>PHP
                            </option>
                            <option value="RUBY" <?php if ($r['language'] == 'RUBY') {
                                echo "selected";
                            } ?>>RUBY
                            </option>
                            <option value="IOS" <?php if ($r['language'] == 'IOS') {
                                echo "selected";
                            } ?>>IOS
                            </option>
                            <option value="MOBILE" <?php if ($r['language'] == 'MOBILE') {
                                echo "selected";
                            } ?>>MOBILE
                            </option>
                            <option value="Q&A" <?php if ($r['language'] == 'Q&A') {
                                echo "selected";
                            } ?>>Q&A
                            </option>
                            </option>
                        </select>
                    </div>
                </div>
                <div style="text-align: center;">
                    <input type="hidden" name="id" value="<?php echo $r["id"]; ?>"/>
                    <input type="submit" class="btn btn-primary" name="update" value="Update">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</div>
</body>
</html>