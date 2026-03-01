<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['temp_agent'])){
    header("Location: agent-login.php");
    exit;
}

if(isset($_POST['save']))
{
    $mpin=$_POST['mpin'];
    $confirm=$_POST['confirm'];

    if($mpin==$confirm && strlen($mpin)==4){

        $hash=password_hash($mpin,PASSWORD_DEFAULT);

        mysqli_query($conn,"UPDATE agents 
        SET mpin='$hash', first_login=0 
        WHERE id='{$_SESSION['temp_agent']}'");

        $_SESSION['agent_id']=$_SESSION['temp_agent'];
        unset($_SESSION['temp_agent']);

        header("Location: dashboard.php");
        exit;
    }
    $error="MPIN must be 4 digits";
}
?>

<form method="POST">
<h3>Create 4 Digit MPIN</h3>
<input type="password" name="mpin" maxlength="4" required>
<input type="password" name="confirm" maxlength="4" required>
<button name="save">Save MPIN</button>
</form>