<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['agent_id']))
{
    header("Location: ../login.php");
}

$agent_id=$_SESSION['agent_id'];
$id=$_GET['id'];

// get account details
$data=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT accounts.*, customers.name, gl_master.ledger_name
FROM accounts
JOIN customers ON customers.id=accounts.customer_id
JOIN gl_master ON gl_master.id=accounts.gl_id
WHERE accounts.id='$id'
"));

// total paid
$paid=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(amount),0) as total FROM transactions WHERE account_id='$id'
"))['total'];

$balance=$data['total_amount']-$paid;

if(isset($_POST['save']))
{
    $amount=$_POST['amount'];
    $date=$_POST['date'];

    if($amount<=0 || $amount>$balance)
    {
        echo "<script>alert('Invalid Amount');</script>";
    }
    else
    {
        // new balance
        $newbal=$balance-$amount;

        // receipt number
        $receipt="RCPT-".date('YmdHis');

        mysqli_query($conn,"INSERT INTO transactions(account_id,agent_id,amount,balance_after,collect_date,receipt_no)
        VALUES('$id','$agent_id','$amount','$newbal','$date','$receipt')");

        echo "<script>alert('Collection Saved');window.location='receipt.php?no=$receipt';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Collect Amount</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card p-4 col-md-6 mx-auto">

<h4><?php echo $data['account_no']; ?></h4>
<p><b>Customer:</b> <?php echo $data['name']; ?></p>
<p><b>Ledger:</b> <?php echo $data['ledger_name']; ?></p>

<hr>

<p><b>Total Amount:</b> ₹<?php echo $data['total_amount']; ?></p>
<p><b>Paid:</b> ₹<?php echo $paid; ?></p>
<p class="text-danger"><b>Balance:</b> ₹<?php echo $balance; ?></p>

<hr>

<form method="POST">
<label>Collect Amount</label>
<input type="number" name="amount" class="form-control mb-3" required>

<label>Date</label>
<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control mb-3">

<button name="save" class="btn btn-success w-100">Save Collection</button>
</form>

<br>
<a href="accounts.php" class="btn btn-secondary w-100">Back</a>

</div>
</div>

</body>
</html>