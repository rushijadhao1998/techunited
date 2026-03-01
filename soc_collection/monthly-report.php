<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['agent_id']))
{
    header("Location: ../login.php");
}

$agent_id=$_SESSION['agent_id'];
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

if(isset($_GET['export']))
{
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=agent_monthly_report.xls");
}

$q=mysqli_query($conn,"
SELECT DATE(collect_date) as dt, SUM(amount) as total
FROM collections
WHERE agent_id='$agent_id' AND DATE_FORMAT(collect_date,'%Y-%m')='$month'
GROUP BY dt
ORDER BY dt
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Monthly Report</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h3>My Monthly Collection</h3>

<form method="GET" class="mb-3">
<input type="month" name="month" value="<?php echo $month; ?>">
<button class="btn btn-primary btn-sm">View</button>
</form>

<a href="?month=<?php echo $month; ?>&export=1" class="btn btn-success mb-3">Download Excel</a>
<button onclick="window.print()" class="btn btn-secondary mb-3">Save PDF</button>

<table class="table table-bordered">
<tr class="table-dark">
<th>Date</th>
<th>Total Amount</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?php echo $r['dt']; ?></td>
<td>₹<?php echo $r['total']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>