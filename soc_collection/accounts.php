<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['agent_id']))
{
    header("Location: ../login.php");
}

$agent_id=$_SESSION['agent_id'];

// get branch of logged agent
$a=mysqli_fetch_assoc(mysqli_query($conn,"SELECT branch_id FROM agents WHERE id='$agent_id'"));
$branch_id=$a['branch_id'];

$search=isset($_GET['search'])?$_GET['search']:'';

$query="
SELECT accounts.*, customers.name, customers.mobile, gl_master.ledger_name
FROM accounts
JOIN customers ON customers.id=accounts.customer_id
JOIN gl_master ON gl_master.id=accounts.gl_id
WHERE accounts.branch_id='$branch_id'
";

if($search!='')
{
$query.=" AND (
accounts.account_no LIKE '%$search%' OR
customers.name LIKE '%$search%' OR
customers.mobile LIKE '%$search%'
)";
}

$query.=" ORDER BY accounts.account_no ASC";

$q=mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Branch Accounts</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

<h3>Branch Accounts</h3>

<form method="GET" class="mb-3">
<input type="text" name="search" class="form-control" placeholder="Search account / name / mobile"
value="<?php echo $search; ?>">
</form>

<table class="table table-bordered">
<tr class="table-dark">
<th>Account No</th>
<th>Customer</th>
<th>Mobile</th>
<th>Ledger</th>
<th>Installment</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?php echo $r['account_no']; ?></td>
<td><?php echo $r['name']; ?></td>
<td><?php echo $r['mobile']; ?></td>
<td><?php echo $r['ledger_name']; ?></td>
<td>₹<?php echo $r['installment_amount']; ?></td>

<td>
<a href="collect.php?id=<?php echo $r['id']; ?>" class="btn btn-success btn-sm">Collect</a>
</td>

</tr>
<?php } ?>

</table>

</div>

</body>
</html>