<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
}

// fetch agents list
$agents=mysqli_query($conn,"SELECT id,name FROM agents");

if(isset($_POST['save']))
{
    $agent=$_POST['agent'];
    $name=$_POST['name'];
    $mobile=$_POST['mobile'];
    $address=$_POST['address'];
    $plan=$_POST['plan'];
    $daily=$_POST['daily'];
    $days=$_POST['days'];
    $start=$_POST['start'];

    mysqli_query($conn,"INSERT INTO members(agent_id,name,mobile,address,plan_amount,daily_amount,total_days,start_date)
    VALUES('$agent','$name','$mobile','$address','$plan','$daily','$days','$start')");

    echo "<script>alert('Member Added Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Member</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card p-4 col-md-7 mx-auto">

<h3>Add Member</h3>

<form method="POST">

<label>Select Agent</label>
<select name="agent" class="form-control mb-3" required>
<option value="">Choose Agent</option>
<?php while($a=mysqli_fetch_assoc($agents)){ ?>
<option value="<?php echo $a['id']; ?>"><?php echo $a['name']; ?></option>
<?php } ?>
</select>

<label>Member Name</label>
<input type="text" name="name" class="form-control mb-3" required>

<label>Mobile</label>
<input type="text" name="mobile" class="form-control mb-3" required>

<label>Address</label>
<textarea name="address" class="form-control mb-3"></textarea>

<label>Plan Amount</label>
<input type="number" name="plan" class="form-control mb-3" required>

<label>Daily Amount</label>
<input type="number" name="daily" class="form-control mb-3" required>

<label>Total Days</label>
<input type="number" name="days" class="form-control mb-3" required>

<label>Start Date</label>
<input type="date" name="start" class="form-control mb-3" required>

<button name="save" class="btn btn-success w-100">Save Member</button>

</form>

<br>
<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</div>

</body>
</html>