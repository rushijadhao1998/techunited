<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['reset_user'])) {
    header("Location: forgot-password.php");
    exit;
}

$msg = "";

if (isset($_POST['reset'])) {
    $newpass = $_POST['password'];
    $confpass = $_POST['confirm'];

    if ($newpass != $confpass) {
        $msg = "Passwords do not match!";
    } else {
        $hash = password_hash($newpass, PASSWORD_DEFAULT);
        $user = $_SESSION['reset_user'];

        mysqli_query($conn, "UPDATE admin SET password='$hash' WHERE username='$user'");

        unset($_SESSION['reset_user']);

        echo "<script>alert('Password Reset Successfully'); window.location='login.php';</script>";
        exit;
    }
}
?>

<style>
    body {
        margin: 0;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: Segoe UI, sans-serif;

        background: linear-gradient(-45deg, #0c3152, #7a1030, #94096d);
        background-size: 400% 400%;
        animation: gradientBG 12s ease infinite;
    }


    .container {
        margin-top: -80px;
    }


    /* animation */
    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .card {
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.35);
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
    }


    .logo-title {
        font-weight: 700;
        color: #1e3a8a;
    }

    
    .fg-pass {
        color: #0c3152;
    }


    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
        padding: 20px 0;
        font-size: 15px;
        color: #ffffff;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        letter-spacing: 0.3px;
    }

    .login-footer a {
        text-decoration: none;
        color: #ffffff;
    }
</style>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="card col-md-4 mx-auto p-4 shadow">

            <h4 class="text-center mb-3">Reset Password</h4>

            <?php if ($msg != "") { ?>
                <div class="alert alert-danger"><?= $msg ?></div>
            <?php } ?>

            <form method="POST">
                <label>New Password</label>
                <input type="password" name="password" class="form-control mb-3" required>

                <label>Confirm Password</label>
                <input type="password" name="confirm" class="form-control mb-3" required>

                <button name="reset" class="btn btn-success w-100">Reset Password</button>
            </form>

        </div>
    </div>

    <footer class="login-footer">
        Copyright © <?= date('Y') ?>, <b><a href="https://unitedtech.in/">UNITED TECHNOLOGIES PVT LTD.</a></b> All Rights Reserved.
    </footer>

</body>

</html>