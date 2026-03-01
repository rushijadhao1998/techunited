<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$agent_id=$_SESSION['agent_id'];
$agent=mysqli_fetch_assoc(mysqli_query($conn,"SELECT mpin FROM agents WHERE id='$agent_id'"));

$status="";
$message="";

if(isset($_POST['save'])){

$old=$_POST['old'];
$new=$_POST['new'];
$confirm=$_POST['confirm'];

if(!($old===$agent['mpin'] || password_verify($old,$agent['mpin']))){
    $status="error";
    $message="Your Current MPIN is Wrong";
}
elseif($new!=$confirm){
    $status="error";
    $message="New MPIN Mismatch";
}
elseif(!preg_match('/^[0-9]{4}$/',$new)){
    $status="error";
    $message="MPIN Must Contain Exactly 4 digits";
}
else{
    $hash=password_hash($new,PASSWORD_DEFAULT);
    mysqli_query($conn,"UPDATE agents SET mpin='$hash' WHERE id='$agent_id'");
    $_SESSION['mpin_success']=true;
    header("Location: change-mpin.php");
    exit;
}

}

?>

<div class="container">
<h5 class="mb-3">Change MPIN</h5>



<form method="POST">

<label>Current MPIN</label>
<input type="password" name="old" class="form-control mb-2 pin" maxlength="4" inputmode="numeric" pattern="[0-9]*" required>

<label>New MPIN</label>
<input type="password" name="new" class="form-control mb-2 pin" maxlength="4" inputmode="numeric" pattern="[0-9]*" required>

<label>Confirm MPIN</label>
<input type="password" name="confirm" class="form-control mb-3 pin" maxlength="4" inputmode="numeric" pattern="[0-9]*" required>

<button class="btn btn-primary w-100" name="save">Update MPIN</button>

</form>
</div>

<?php if(isset($_SESSION['mpin_success'])){ ?>
<script>
Swal.fire({
    icon:'success',
    title:'MPIN Updated',
    text:'Your MPIN Changed Successfully',
    confirmButtonColor:'#0d6efd'
});
</script>
<?php unset($_SESSION['mpin_success']); } ?>

<?php if(!empty($message)){ ?>
<script>
Swal.fire({
    icon:'error',
    title:'Oops',
    text:'<?=$message?>',
    confirmButtonColor:'#d33'
});
</script>
<?php } ?>


<script>
document.querySelectorAll(".pin").forEach(el=>{
    el.addEventListener("input",()=>{
        el.value = el.value.replace(/[^0-9]/g,'').slice(0,4);
    });
});
</script>

<?php include "layout/footer.php"; ?>