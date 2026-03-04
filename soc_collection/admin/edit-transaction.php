<?php
session_start();
include "../config/db.php";

$id=$_GET['id'];

$data=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT t.*, a.account_no, c.name
FROM transactions t
JOIN accounts a ON a.id=t.account_id
JOIN customers c ON c.id=a.customer_id
WHERE t.id='$id'
"));

if(isset($_POST['update']))
{
    $amount=$_POST['amount'];
    $date=$_POST['date'];

    mysqli_query($conn,"UPDATE transactions 
    SET amount='$amount', collect_date='$date' 
    WHERE id='$id'");

    $branch=$_GET['branch'];
    $ledger=$_GET['ledger'];
    $agent=$_GET['agent'];
    $from=$_GET['from'];
    $to=$_GET['to'];
    $type=$_GET['type'];
    $order=$_GET['order'];

    echo "<script>
    alert('Updated Successfully');
    window.location='agent-statement.php?show=1&branch=$branch&ledger=$ledger&agent=$agent&from=$from&to=$to&type=$type&order=$order';
    </script>";
}
include "layout/header.php";
include "layout/sidebar.php";
?>

<h3>Edit Collection</h3>

<div class="card p-4 col-md-5">

<p><b>Account:</b> <?=$data['account_no']?></p>
<p><b>Name:</b> <?=$data['name']?></p>

<form method="POST">
<label>Date</label>
<input type="date" name="date" value="<?=$data['collect_date']?>" class="form-control mb-3">

<label>Amount</label>
<input type="number" name="amount" value="<?=$data['amount']?>" class="form-control mb-3">

<button name="update" class="btn btn-primary">Update</button>
<a href="agent-statement.php" class="btn btn-secondary">Back</a>
</form>

</div>

<?php include "layout/footer.php"; ?>