<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$customers=mysqli_query($conn,"SELECT id,customer_code,name FROM customers WHERE status='active'");
$gls=mysqli_query($conn,"SELECT id,glid,ledger_name FROM gl_master WHERE status='active'");

if(isset($_POST['save']))
{
    $customer=$_POST['customer'];
    $gl=$_POST['gl'];
    $date=$_POST['date'];
    $inst=$_POST['inst'];
    $total=$_POST['total'];

    // fetch codes
    $c=mysqli_fetch_assoc(mysqli_query($conn,"SELECT customer_code FROM customers WHERE id='$customer'"));
    $g=mysqli_fetch_assoc(mysqli_query($conn,"SELECT glid FROM gl_master WHERE id='$gl'"));

    $accno=$g['glid']."-".$c['customer_code'];

    mysqli_query($conn,"INSERT INTO accounts(account_no,customer_id,gl_id,open_date,installment_amount,total_amount)
    VALUES('$accno','$customer','$gl','$date','$inst','$total')");

    echo "<script>alert('Account Opened: $accno');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Open Account</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 col-md-7 mx-auto">

<h3>Open Account</h3>

<form method="POST">

<label>Customer</label>
<select name="customer" class="form-control mb-3" required>
<option value="">Select Customer</option>
<?php while($c=mysqli_fetch_assoc($customers)){ ?>
<option value="<?php echo $c['id']; ?>">
<?php echo $c['customer_code']." - ".$c['name']; ?>
</option>
<?php } ?>
</select>

<label>Ledger (GLID)</label>
<select name="gl" class="form-control mb-3" required>
<option value="">Select Ledger</option>
<?php while($g=mysqli_fetch_assoc($gls)){ ?>
<option value="<?php echo $g['id']; ?>">
<?php echo $g['glid']." - ".$g['ledger_name']; ?>
</option>
<?php } ?>
</select>

<label>Open Date</label>
<input type="date" name="date" class="form-control mb-3" required>

<label>Installment Amount</label>
<input type="number" name="inst" class="form-control mb-3" required>

<label>Total Amount</label>
<input type="number" name="total" class="form-control mb-3">

<button name="save" class="btn btn-primary w-100">Open Account</button>

</form>

<br>
<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</div>
</body>
</html>