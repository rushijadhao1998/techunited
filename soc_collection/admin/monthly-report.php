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
    header("Content-Disposition: attachment; filename=monthly_report.xls");
}

$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

$q=mysqli_query($conn,"
SELECT agents.name, SUM(collections.amount) as total
FROM collections
JOIN agents ON agents.id=collections.agent_id
WHERE DATE_FORMAT(collect_date,'%Y-%m')='$month'
GROUP BY agents.id
ORDER BY total DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Monthly Agent Report</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h3>Agent Monthly Collection</h3>

<form method="GET" class="mb-3">
<input type="month" name="month" value="<?php echo $month; ?>">
<button class="btn btn-primary btn-sm">View</button>
</form>

<a href="monthly-report.php?month=<?php echo $month; ?>&export=1"
class="btn btn-success mb-3">Download Excel</a>

<table class="table table-bordered">
<tr class="table-dark">
<th>Agent Name</th>
<th>Total Collection</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?php echo $r['name']; ?></td>
<td class="fw-bold text-success">₹<?php echo $r['total'] ? $r['total'] : 0; ?></td>
</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</body>
</html>