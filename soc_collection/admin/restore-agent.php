<?php
session_start();
include "../config/db.php";

$id=$_GET['id'];

mysqli_query($conn,"UPDATE agents SET status='active' WHERE id='$id'");

header("Location: inactive-agents.php");
?>