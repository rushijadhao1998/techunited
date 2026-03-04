<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

if (isset($_POST['save'])) {
    $glid = $_POST['glid'];
    $name = $_POST['name'];
    $date = date('Y-m-d');

    // check duplicate
    $check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM gl_master WHERE glid='$glid'"));

    if ($check) {
        echo "<script>alert('GLID Already Exists! Use Different Ledger Number');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO gl_master(glid,ledger_name,created_date)
    VALUES('$glid','$name','$date')");

        echo "<script>alert('Ledger Created Successfully');</script>";
    }

    // echo "<script>alert('Ledger Created');</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Ledger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 col-md-6 mx-auto">

            <h3>Create Ledger</h3>

            <form method="POST">

                <label>GLID</label>
                <input type="text" name="glid" class="form-control mb-3" required>

                <label>Ledger Name</label>
                <input type="text" name="name" class="form-control mb-3" required>

                <button name="save" class="btn btn-primary w-100">Save Ledger</button>

            </form>

            <br>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>

        </div>
    </div>
</body>

</html>