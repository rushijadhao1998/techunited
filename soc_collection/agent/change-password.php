<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$agent_id=$_SESSION['agent_id'];
$agent=mysqli_fetch_assoc(mysqli_query($conn,"SELECT password FROM agents WHERE id='$agent_id'"));

$msg="";

$message="";

if(isset($_POST['save'])){

$old=$_POST['old'];
$new=$_POST['new'];
$confirm=$_POST['confirm'];

if(!password_verify($old,$agent['password'])){
    $status="error";
    $message="Wrong current password";
}
elseif($new!=$confirm){
    $status="error";
    $message="Password Mismatch";
}
elseif(strlen($new)<4){
    $status="error";
    $message="Password Too Short (Minimum 4 Character)";
}
else{
    $hash=password_hash($new,PASSWORD_DEFAULT);
    mysqli_query($conn,"UPDATE agents SET password='$hash' WHERE id='$agent_id'");
    $_SESSION['pass_success']=true;
    header("Location: change-password.php");
    exit;
}

}

?>

<div class="container">
<h5 class="mb-3">Change Password</h5>

<?php if($msg!="") echo "<div class='alert alert-info'>$msg</div>"; ?>

<form method="POST">

<label>Current Password</label>
<input type="password" name="old" class="form-control mb-2" required>

<label>New Password</label>
<input type="password" name="new" class="form-control mb-2" required>

<label>Confirm Password</label>
<input type="password" name="confirm" class="form-control mb-3" required>

<button class="btn btn-dark w-100" name="save">Update Password</button>

</form>
</div>


<?php if(isset($_SESSION['pass_success'])){ ?>
<script>
Swal.fire({
    icon:'success',
    title:'Password Updated',
    text:'Your password Changed Successfully',
    confirmButtonColor:'#0d6efd'
});
</script>
<?php unset($_SESSION['pass_success']); } ?>

<?php if(!empty($message)){ ?>
<script>
Swal.fire({
    icon:'error',
    title:'Error',
    text:'<?=$message?>',
    confirmButtonColor:'#d33'
});
</script>
<?php } ?>

<?php include "layout/footer.php"; ?>