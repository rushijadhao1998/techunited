<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
}

$id=$_GET['id'];

mysqli_query($conn,"UPDATE agents SET status='inactive' WHERE id='$id'");

header("Location: agent-list.php");
?>