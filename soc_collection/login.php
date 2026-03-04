<?php
session_start();
include "config/db.php";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $q = mysqli_query($conn,"SELECT * FROM agents WHERE username='$username'");
    $data = mysqli_fetch_assoc($q);

    if($data && password_verify($password,$data['password']))
    {
        $_SESSION['agent_id'] = $data['id'];
        $_SESSION['name'] = $data['name'];
        header("Location: agent/dashboard.php");
    }
    else
    {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Agent Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<div class="card p-4 col-md-4 mx-auto">
<h3 class="text-center">Agent Login</h3>

<form method="POST">
<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button name="login" class="btn btn-primary w-100">Login</button>
</form>

</div>
</div>

</body>
</html>