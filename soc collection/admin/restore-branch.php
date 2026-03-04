<?php
session_start();
include "../config/db.php";


$id=$_GET['id'];

mysqli_query($conn,"UPDATE branches SET status='active' WHERE id='$id'");

header("Location: inactive-branches.php");
?>