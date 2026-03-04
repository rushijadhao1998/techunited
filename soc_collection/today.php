<?php
session_start();
include "../config/db.php";

$agent_id = $_SESSION['agent_id'];
$date = date('Y-m-d');

$q = mysqli_query($conn,"
SELECT members.name, collections.amount, collections.receipt_no
FROM collections
JOIN members ON members.id = collections.member_id
WHERE collections.agent_id='$agent_id' AND collect_date='$date'
");

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Today Collection</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
<h3>Today's Collection</h3>

<table class="table table-bordered">
<tr class="table-dark">
<th>Member</th>
<th>Amount</th>
<th>Receipt</th>
</tr>

<?php while($row=mysqli_fetch_assoc($q)) { $total += $row['amount']; ?>

<tr>
<td><?php echo $row['name']; ?></td>
<td>₹<?php echo $row['amount']; ?></td>
<td><?php echo $row['receipt_no']; ?></td>
</tr>

<?php } ?>

<tr class="table-success">
<td><b>Total</b></td>
<td colspan="2"><b>₹<?php echo $total; ?></b></td>
</tr>

</table>

</div>

</body>
</html>