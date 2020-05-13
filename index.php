<?php
include_once('./Classes/User.php');
include_once("./Classes/Crud.php");
$user = new User();
$crud = new Crud();

if (isset($_COOKIE["user_login"]) && isset($_COOKIE["pass_login"])) {
    $acc = $_COOKIE["user_login"];
    $pass = $_COOKIE["pass_login"];
    $sql2 = "Select * from users where uemail='$acc' or uname='$acc' and upass='$pass'";
    $result = $user->db->query($sql2);
    $data = mysqli_fetch_array($result);
    if ($result != false) {
        $_SESSION['login'] = true;
        $_SESSION["uid"] = $data["uid"];
    }
}
$uid = $_SESSION['uid'];
if (!$user->get_session()) {
    header("location:login.php");
}

if (isset($_GET['out'])) {
    $user->user_logout();
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<div>
    <div class="jumbotron text-center">
        <h2>Hello <b><?php $user->get_fullname($uid); ?>!</b></h2>
        <a class="btn btn-primary btn-md" href="index.php?out=logout">LOGOUT</a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Employees</b></h2>
                </div>
                <div class="col-sm-6" style="margin-top: 20px">
                    <a href="create.php" class="btn btn-success pull-right"><span>Create Employee</span></a>
                </div>
            </div>
        </div>
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
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>E-Mail</th>
                <th>Gender</th>
                <th>Language</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
            $res = $crud->read();
            while($r = mysqli_fetch_assoc($res)){
                ?>
                <tr id="<?php echo $r["id"]; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $r['first_name'] . " " . $r['last_name']; ?></td>
                    <td><?php echo $r['email_id']; ?></td>
                    <td><?php echo $r['gender']; ?></td>
                    <td><?php echo $r['language']; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $r['id']; ?>" title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span> Update</a>
                        <a href="delete.php?id=<?php echo $r['id']; ?>" onclick=" return confirm('Are you sure want to delete this record?')" title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span> Delete</a>
                    </td>
                </tr>
            <?php
                $i++;
            } ?>
            </tbody>
        </table>
    </div>
</div>
</body>

</html>

