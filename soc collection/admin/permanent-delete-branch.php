<?php
session_start();
include "../config/db.php";

$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM branches WHERE id='$id'");

header("Location: inactive-branches.php");
?>