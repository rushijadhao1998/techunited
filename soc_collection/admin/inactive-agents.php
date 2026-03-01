<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
}

$q=mysqli_query($conn,"
SELECT agents.*, branches.branch_name
FROM agents
LEFT JOIN branches ON branches.id=agents.branch_id
WHERE agents.status='inactive'
ORDER BY agents.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Inactive Agents</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4">

<h3>Inactive Agents</h3>

<table class="table table-bordered">
<tr class="table-dark">
<th>ID</th>
<th>Agent Code</th>
<th>Branch</th>
<th>Name</th>
<th>Mobile</th>
<th>Username</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?php echo $r['id']; ?></td>
<td><?php echo $r['agent_code']; ?></td>
<td><?php echo $r['branch_name']; ?></td>
<td><?php echo $r['name']; ?></td>
<td><?php echo $r['mobile']; ?></td>
<td><?php echo $r['username']; ?></td>

<td>
<a href="restore-agent.php?id=<?php echo $r['id']; ?>"
class="btn btn-success btn-sm">Restore</a>

<a href="permanent-delete-agent.php?id=<?php echo $r['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Permanently delete agent?')">Delete</a>
</td>

</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</body>
</html>