<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$q=mysqli_query($conn,"SELECT * FROM branches WHERE status='inactive'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Inactive Branches</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">

<h3>Inactive Branches</h3>

<table class="table table-bordered">
<tr class="table-dark">
<th>Code</th>
<th>Name</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?php echo $r['branch_code']; ?></td>
<td><?php echo $r['branch_name']; ?></td>
<td>
<a href="restore-branch.php?id=<?php echo $r['id']; ?>" class="btn btn-success btn-sm">Restore</a>
<a href="permanent-delete-branch.php?id=<?php echo $r['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Permanent delete?')">Delete</a>
</td>
</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</body>
</html>