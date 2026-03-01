<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
}

if(isset($_GET['export']))
{
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=daily_report.xls");
}

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$q=mysqli_query($conn,"
SELECT collections.*, members.name as member, agents.name as agent
FROM collections
JOIN members ON members.id=collections.member_id
JOIN agents ON agents.id=collections.agent_id
WHERE collect_date='$date'
ORDER BY agents.name
");

$total=0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Daily Report</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h3>Daily Collection Report</h3>

<form method="GET" class="mb-3">
<input type="date" name="date" value="<?php echo $date; ?>">
<button class="btn btn-primary btn-sm">View</button>
</form>

<a href="daily-report.php?date=<?php echo $date; ?>&export=1"
class="btn btn-success mb-3">Download Excel</a>

<table class="table table-bordered">
<tr class="table-dark">
<th>Agent</th>
<th>Member</th>
<th>Amount</th>
<th>Receipt</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ $total+=$r['amount']; ?>
<tr>
<td><?php echo $r['agent']; ?></td>
<td><?php echo $r['member']; ?></td>
<td>₹<?php echo $r['amount']; ?></td>
<td><?php echo $r['receipt_no']; ?></td>
</tr>
<?php } ?>

<tr class="table-success">
<td colspan="2"><b>Total</b></td>
<td colspan="2"><b>₹<?php echo $total; ?></b></td>
</tr>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</body>
</html>