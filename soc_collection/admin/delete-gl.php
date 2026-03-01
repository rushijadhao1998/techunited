<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id=$_GET['id'];

// soft delete
mysqli_query($conn,"UPDATE gl_master SET status='inactive' WHERE id='$id'");

header("Location: gl-list.php");
exit;
?>