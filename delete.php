<?php
include_once("./Classes/Crud.php");
$crud = new Crud();
$id = $_GET["id"];
$res = $crud->delete($id);
if ($res) {
    header("location:index.php");
} else {
    echo "<script>alert('Failed to delete Record!');</script>";
}
?>