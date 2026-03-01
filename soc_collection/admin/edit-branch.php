<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$id=$_GET['id'];

$data=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM branches WHERE id='$id'"));

if(isset($_POST['update']))
{
    $name=$_POST['name'];
    $code=$_POST['code'];
    $address=$_POST['address'];
    $mobile=$_POST['mobile'];

    mysqli_query($conn,"UPDATE branches SET
    branch_name='$name',
    branch_code='$code',
    address='$address',
    mobile='$mobile'
    WHERE id='$id'");

    header("Location: branch-list.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Branch</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 col-md-6 mx-auto">

<h3>Edit Branch</h3>

<form method="POST">
<input type="text" name="name" value="<?php echo $data['branch_name']; ?>" class="form-control mb-3">
<input type="text" name="code" value="<?php echo $data['branch_code']; ?>" class="form-control mb-3">
<textarea name="address" class="form-control mb-3"><?php echo $data['address']; ?></textarea>
<input type="text" name="mobile" value="<?php echo $data['mobile']; ?>" class="form-control mb-3">
<button name="update" class="btn btn-primary w-100">Update</button>
</form>

<br>
<a href="branch-list.php" class="btn btn-secondary">Back</a>

</div>
</div>
</body>
</html>