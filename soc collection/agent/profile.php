<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$agent_id = $_SESSION['agent_id'];

/* UPDATE PROFILE */
if(isset($_POST['save'])){

    $mobile  = $_POST['mobile'];
    $email   = $_POST['email'];
    $address = $_POST['address'];

    /* PHOTO UPLOAD */
    if(!empty($_FILES['photo']['name'])){

        $img = time()."_".$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'],"../assets/images/".$img);

        mysqli_query($conn,"UPDATE agents SET photo='$img' WHERE id='$agent_id'");
    }

    mysqli_query($conn,"UPDATE agents 
    SET mobile='$mobile', email='$email', address='$address'
    WHERE id='$agent_id'");

    $_SESSION['profile_updated'] = true;
header("Location: profile.php");
exit;
}

/* GET DATA */
$agent = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM agents WHERE id='$agent_id'
"));
?>

<div class="container">

<h5 class="mb-3">My Profile</h5>

<form method="POST" enctype="multipart/form-data">

<div class="card p-3 text-center mb-3">

<img src="../assets/images/<?=$agent['photo'] ?? 'default.png'?>" 
style="width:100px;height:100px;border-radius:50%;object-fit:cover;margin:auto">

<input type="file" name="photo" class="form-control mt-2">

</div>

<div class="card p-3 mb-3">

<label>Agent Name</label>
<input type="text" class="form-control mb-2" value="<?=$agent['name']?>" readonly>

<label>Agent ID</label>
<input type="text" class="form-control mb-2" value="<?=$agent['agent_code']?>" readonly>

<label>Phone</label>
<input type="text" name="mobile" class="form-control mb-2" value="<?=$agent['mobile']?>">

<label>Email</label>
<input type="email" name="email" class="form-control mb-2" value="<?=$agent['email']?>">

<label>Address</label>
<textarea name="address" class="form-control"><?=$agent['address']?></textarea>

</div>

<button class="btn btn-primary w-100" name="save">Update Profile</button>

<hr class="my-4">

<a href="change-mpin.php" class="btn btn-warning w-100 mb-2">
    Change MPIN
</a>

<a href="change-password.php" class="btn btn-dark w-100">
    Change Password
</a>

</form>

</div>

<?php if(isset($_SESSION['profile_updated'])){ ?>
<script>
document.addEventListener("DOMContentLoaded", function(){

    Swal.fire({
        icon: 'success',
        title: 'Profile Updated',
        text: 'Your information saved successfully',
        confirmButtonColor: '#0d6efd',
        confirmButtonText: 'OK',
        backdrop: true
    });

});
</script>
<?php unset($_SESSION['profile_updated']); } ?>

<?php include "layout/footer.php"; ?>