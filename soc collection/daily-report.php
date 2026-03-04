<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['agent_id']))
{
    header("Location: ../login.php");
}

$agent_id=$_SESSION['agent_id'];
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

if(isset($_GET['export']))
{
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=agent_daily_report.xls");
}

$q=mysqli_query($conn,"
SELECT members.name, collections.amount, collections.receipt_no
FROM collections
JOIN members ON members.id=collections.member_id
WHERE collections.agent_id='$agent_id' AND collect_date='$date'
");

$total=0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Daily Report</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h3>My Daily Collection</h3>

<form method="GET" class="mb-3">
<input type="date" name="date" value="<?php echo $date; ?>">
<button class="btn btn-primary btn-sm">View</button>
</form>

<a href="?date=<?php echo $date; ?>&export=1" class="btn btn-success mb-3">Download Excel</a>
<button onclick="window.print()" class="btn btn-secondary mb-3">Save PDF</button>

<table class="table table-bordered">
<tr class="table-dark">
<th>Member</th>
<th>Amount</th>
<th>Receipt</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ $total+=$r['amount']; ?>
<tr>
<td><?php echo $r['name']; ?></td>
<td>₹<?php echo $r['amount']; ?></td>
<td><?php echo $r['receipt_no']; ?></td>
</tr>
<?php } ?>

<tr class="table-success">
<td><b>Total</b></td>
<td colspan="2"><b>₹<?php echo $total; ?></b></td>
</tr>

</table>

</body>
</html>