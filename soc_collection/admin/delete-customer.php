<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$id=$_GET['id'];

mysqli_query($conn,"UPDATE customers SET status='inactive' WHERE id='$id'");

header("Location: customer-list.php");
?>