<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['agent_id']))
{
    header("Location: ../login.php");
}

$agent_id = $_SESSION['agent_id'];
$search = isset($_GET['search']) ? $_GET['search'] : '';

$q = mysqli_query($conn,"
SELECT m.*,
IFNULL((
    SELECT SUM(c.amount)
    FROM collections c
    WHERE c.member_id = m.id
),0) AS paid
FROM members m
WHERE m.agent_id='$agent_id'
AND (
    m.name LIKE '%$search%'
    OR m.mobile LIKE '%$search%'
    OR '$search'=''
)
ORDER BY (m.plan_amount - paid) > 0 DESC, m.name ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Members</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">
<h3 class="mb-3">My Members</h3>

<form method="GET" class="mb-3">
<div class="input-group">
<input type="text" name="search" class="form-control" placeholder="Search name or mobile..."
value="<?php echo isset($_GET['search'])?$_GET['search']:''; ?>">
<button class="btn btn-primary">Search</button>
<a href="members.php" class="btn btn-secondary">Reset</a>
</div>
</form>

<table class="table table-bordered">
<tr class="table-dark">
<th>Name</th>
<th>Daily Amount</th>
<th>Remaining</th>
<th>Action</th>
</tr>

<?php
while($row=mysqli_fetch_assoc($q))
{
    $member_id = $row['id'];

    $paid = $row['paid'];

    $remaining = $row['plan_amount'] - $paid;

    $isCompleted = ($remaining <= 0);
?>

<tr class="<?php echo $isCompleted ? 'table-success' : ''; ?>">

<td><?php echo $row['name']; ?></td>

<td>₹<?php echo $row['daily_amount']; ?></td>

<td class="fw-bold <?php echo $isCompleted ? 'text-success' : 'text-danger'; ?>">
<?php echo $isCompleted ? 'Completed' : '₹'.$remaining; ?>
</td>

<td>
<?php if(!$isCompleted){ ?>
<a href="collect.php?id=<?php echo $member_id; ?>" class="btn btn-success btn-sm">Collect</a>
<?php } else { ?>
<span class="badge bg-success">Finished</span>
<?php } ?>
</td>

</tr>

<?php } ?>

</table>
</div>

</body>
</html>