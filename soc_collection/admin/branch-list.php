<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
}

$q=mysqli_query($conn,"SELECT * FROM branches WHERE status='active' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Branch List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4">

<h3>Branch List</h3>

<table class="table table-bordered">
<tr class="table-dark">
<th>Code</th>
<th>Name</th>
<th>Mobile</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?php echo $r['branch_code']; ?></td>
<td><?php echo $r['branch_name']; ?></td>
<td><?php echo $r['mobile']; ?></td>
<td><?php echo $r['status']; ?></td>
<td>
<a href="edit-branch.php?id=<?php echo $r['id']; ?>" class="btn btn-sm btn-primary">Edit</a>

<a href="delete-branch.php?id=<?php echo $r['id']; ?>"
class="btn btn-sm btn-danger"
onclick="return confirm('Deactivate branch?')">
Delete
</a>
</td>
</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</body>
</html>