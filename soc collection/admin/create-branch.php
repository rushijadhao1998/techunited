<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
}

if(isset($_POST['save']))
{
    $name=$_POST['name'];
    $code=$_POST['code'];
    $address=$_POST['address'];
    $mobile=$_POST['mobile'];

    mysqli_query($conn,"INSERT INTO branches(branch_name,branch_code,address,mobile)
    VALUES('$name','$code','$address','$mobile')");

    echo "<script>alert('Branch Created');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Branch</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 col-md-6 mx-auto">

<h3>Create Branch</h3>

<form method="POST">
<input type="text" name="name" class="form-control mb-3" placeholder="Branch Name" required>
<input type="text" name="code" class="form-control mb-3" placeholder="Branch Code" required>
<textarea name="address" class="form-control mb-3" placeholder="Address"></textarea>
<input type="text" name="mobile" class="form-control mb-3" placeholder="Mobile">

<button name="save" class="btn btn-primary w-100">Save Branch</button>
</form>

<br>
<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</div>
</body>
</html>