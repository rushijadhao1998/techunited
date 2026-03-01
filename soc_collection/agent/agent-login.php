<?php
session_start();
include "../config/db.php";

$error = "";
$saved_user = $_COOKIE['agent_user'] ?? '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM agents WHERE username='$username' AND status='active'");
    $agent = mysqli_fetch_assoc($q);

    if ($agent && password_verify($password, $agent['password'])) {
        $_SESSION['temp_agent'] = $agent['id'];

        // remember username
        if (isset($_POST['remember'])) {
            setcookie("agent_user", $username, time() + 60 * 60 * 24 * 30, "/");
        } else {
            setcookie("agent_user", "", time() - 3600, "/");
        }

        if ($agent['mpin'] == NULL) {
            header("Location: create-mpin.php");
        } else {
            header("Location: mpin-login.php");
        }
        exit;
    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Agent Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

        .login-card {
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

        .login-footer {
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

        a {
            text-decoration: none;
            color: #ffffff;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-5 col-lg-4">

                <div class="card login-card p-4">

                    <div class="text-center mb-3">
                        <h4 class="fw-bold text-primary">UNITED TECH CREDIT CO-OPERATIVE SOCIETY</h4>
                        <div class="text-muted small">Agent Collection System</div>
                    </div>

                    <?php if ($error) { ?>
                        <div class="alert alert-danger py-2"><?= $error ?></div>
                    <?php } ?>

                    <form method="POST">

                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control"
                                value="<?= htmlspecialchars($saved_user) ?>" placeholder="Username" required>
                            <label><i class="bi bi-person"></i> Username</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <label><i class="bi bi-lock"></i> Password</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" <?= $saved_user ? 'checked' : '' ?>>
                                <label class="form-check-label">Remember Me</label>
                            </div>

                            <a href="forgot-agent.php" class="small text-decoration-none fg-pass">Forgot Password?</a>
                        </div>

                        <button name="login" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <footer class="login-footer">
        Copyright © <?= date('Y') ?>, <b><a href="https://unitedtech.in/">UNITED TECHNOLOGIES PVT LTD.</a></b> All Rights Reserved.
    </footer>

</body>

</html>