<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['temp_agent'])) {
    header("Location: agent-login.php");
    exit;
}

$agent = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT id,name,mpin FROM agents WHERE id='{$_SESSION['temp_agent']}'"));

$error = "";

if (isset($_POST['verify'])) {

    $entered = $_POST['mpin'] ?? '';
    $dbmpin  = $agent['mpin'];

    // support plain + hashed
    if ($entered === $dbmpin || password_verify($entered, $dbmpin)) {

        $_SESSION['agent_id'] = $agent['id'];
        unset($_SESSION['temp_agent']);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Wrong MPIN";
    }
}


if (!empty($error)) { ?>
    <script>
        document.querySelector(".login-card").classList.add("shake");
        setTimeout(() => document.querySelector(".login-card").classList.remove("shake"), 400);
    </script>
<?php }

?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MPIN Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f1f1f1;
            font-family: Segoe UI;
        }

        .top img {
            height: 80px;
            margin-bottom: 10px;
        }

        .society {
            font-size: 18px;
            font-weight: 600;
        }

        /* HEADER */
        .top {
            background: linear-gradient(160deg, #662d91, #8a4fff);
            color: white;
            padding: 30px 20px 110px;
            text-align: center;
        }

        .card-login {
            background: white;
            margin: -80px 18px 0;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .6);
            text-align: center;
        }

        .welcome {
            color: #555;
            font-size: 14px;
        }

        /* PIN BOXES */
        .pinbox {
            width: 55px;
            height: 60px;
            border: 2px solid #ccc;
            border-radius: 10px;
            font-size: 28px;
            text-align: center;
            margin: 5px;
        }

        .pinbox:focus {
            border-color: #8a4fff;
            outline: none;
        }

        .error {
            color: red;
            font-size: 14px;
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

        .login-footer a {
            text-decoration: none;
            color: #ffffff;
        }

        @keyframes shake {
            0% {
                transform: translateX(0)
            }

            25% {
                transform: translateX(-6px)
            }

            50% {
                transform: translateX(6px)
            }

            75% {
                transform: translateX(-6px)
            }

            100% {
                transform: translateX(0)
            }
        }

        .shake {
            animation: shake .35s
        }
    </style>
</head>

<body>

    <div class="top">
        <img src="../assets/images/logo.png">
        <div class="society">UNITED TECH CREDIT CO-OPERATIVE SOCIETY</div>
    </div>

    <div class="card-login">

        <h5 class="welcome">Welcome</h5>
        <h3><?= $agent['name'] ?></h3>

        <h6 class="mb-3">Login Using MPIN</h6>

        <?php if ($error) { ?>
            <div class="error"><?= $error ?></div>
        <?php } ?>

        <form method="POST" id="mpinform">



            <div class="d-flex justify-content-center">
                <input type="password" maxlength="1" class="pinbox" inputmode="numeric">
                <input type="password" maxlength="1" class="pinbox" inputmode="numeric">
                <input type="password" maxlength="1" class="pinbox" inputmode="numeric">
                <input type="password" maxlength="1" class="pinbox" inputmode="numeric">
            </div>

            <input type="hidden" name="mpin" id="finalPin">
            <button name="verify" hidden id="submitBtn">Login</button>

        </form>

        <div class="mt-3 text-primary">Forgot MPIN?</div>
        <hr>
        <div class="text-muted">Login with <a href="agent-login.php">Username</a></div>

    </div>


    <script>


        const inputs = document.querySelectorAll(".pinbox");
        let pin = "";

        inputs.forEach((box, index) => {

            box.addEventListener("input", () => {

                if (box.value.length == 1) {
                    if (index < 3) {
                        inputs[index + 1].focus();
                    } else {
                        collectPin();
                    }
                }

            });

            box.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && box.value === "") {
                    if (index > 0) inputs[index - 1].focus();
                }
            });

        });

        function collectPin() {
            pin = "";
            inputs.forEach(i => pin += i.value);

            if (pin.length === 4) {
                document.getElementById("finalPin").value = pin;
                document.getElementById("submitBtn").click();
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelector(".pinbox").focus();
        });
    </script>

    <footer class="login-footer">
        Copyright © <?= date('Y') ?>, <b><a href="https://unitedtech.in/">UNITED TECHNOLOGIES PVT LTD.</a></b> All Rights Reserved.
    </footer>

</body>

</html>