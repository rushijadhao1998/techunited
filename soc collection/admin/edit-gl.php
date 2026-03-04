<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$id=$_GET['id'];
$data=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM gl_master WHERE id='$id'"));

if(isset($_POST['update']))
{
    $glid=$_POST['glid'];
    $name=$_POST['name'];

    mysqli_query($conn,"UPDATE gl_master SET glid='$glid',ledger_name='$name' WHERE id='$id'");

    header("Location: gl-list.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Ledger</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 col-md-6 mx-auto">

<h3>Edit Ledger</h3>

<form method="POST">
<input type="text" name="glid" value="<?php echo $data['glid']; ?>" class="form-control mb-3">
<input type="text" name="name" value="<?php echo $data['ledger_name']; ?>" class="form-control mb-3">
<button name="update" class="btn btn-primary w-100">Update</button>
</form>

<br>
<a href="gl-list.php" class="btn btn-secondary">Back</a>

</div>
</div>
</body>
</html>