<?php
session_start();
include "../config/db.php";

$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM gl_master WHERE id='$id'");

header("Location: inactive-gl.php");
?>