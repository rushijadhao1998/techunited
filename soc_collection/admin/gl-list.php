<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$q=mysqli_query($conn,"SELECT * FROM gl_master WHERE status='active' ORDER BY id DESC");
$sr=1;
?>

<!DOCTYPE html>
<html>
<head>
<title>Ledger List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4">

<h3>Ledger List</h3>

<table class="table table-bordered">
<tr class="table-dark">
<th>Sr No</th>
<th>GLID</th>
<th>Ledger Name</th>
<th>Created Date</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?php echo $sr++; ?></td>
<td><?php echo $r['glid']; ?></td>
<td><?php echo $r['ledger_name']; ?></td>
<td><?php echo $r['created_date']; ?></td>
<td><?php echo $r['status']; ?></td>

<td>
<a href="edit-gl.php?id=<?php echo $r['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
<a href="delete-gl.php?id=<?php echo $r['id']; ?>" class="btn btn-sm btn-danger"
onclick="return confirm('Delete ledger?')">Delete</a>
</td>
</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>

</div>
</body>
</html>