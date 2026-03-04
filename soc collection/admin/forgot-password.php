<?php
session_start();
include "../config/db.php";

$msg = "";

if (isset($_POST['check'])) {
    $username = $_POST['username'];

    $q = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    $data = mysqli_fetch_assoc($q);

    if ($data) {
        $_SESSION['reset_user'] = $username;
        header("Location: reset-password.php");
        exit;
    } else {
        $msg = "Username not found!";
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

    .shadow {
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.35);
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
    }



    .logo-title {
        font-weight: 700;
        color: #1e3a8a;
    }

    .welcome {
        font-size: 14px;
        color: #6c757d;
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
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="card col-md-4 mx-auto p-4 shadow">

            <h4 class="text-center mb-3">Forgot Password</h4>

            <?php if ($msg != "") { ?>
                <div class="alert alert-danger"><?= $msg ?></div>
            <?php } ?>

            <form method="POST">
                <label>Enter Username</label>
                <input type="text" name="username" class="form-control mb-3" required>
                <button name="check" class="btn btn-primary w-100">Continue</button>
            </form>

            <br>
            <a href="login.php" class="btn btn-secondary w-100">Back to Login</a>

        </div>
    </div>

    <footer class="login-footer">
        Copyright © <?= date('Y') ?>, <b><a href="https://unitedtech.in/">UNITED TECHNOLOGIES PVT LTD.</a></b> All Rights Reserved.
    </footer>

</body>

</html>