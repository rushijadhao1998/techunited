<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$agent_id = $_SESSION['agent_id'];

/* APPLY BUTTON CHECK */
$show = isset($_GET['apply']);

/* FILTERS */
$ledger_id = $_GET['ledger'] ?? '';
$search    = $_GET['search'] ?? '';
$sort      = $_GET['sort'] ?? 'account_no';

/* LEDGER LIST */
$ledgers = mysqli_query($conn, "
SELECT id,ledger_name FROM gl_master 
WHERE status='active'
ORDER BY ledger_name ASC
");

/* RUN QUERY ONLY AFTER APPLY */
$result = false;

if($show){

$query = "
SELECT 
a.id,
a.account_no,
a.total_amount,
a.installment_amount,
c.name,
gl.ledger_name,
IFNULL(SUM(t.amount),0) AS paid

FROM accounts a
JOIN customers c ON c.id=a.customer_id
JOIN gl_master gl ON gl.id=a.gl_id
LEFT JOIN transactions t ON t.account_id=a.id

WHERE c.agent_id='$agent_id'
";

if ($ledger_id != '') {
    $query .= " AND a.gl_id='$ledger_id'";
}

if ($search != '') {
    $query .= " AND (c.name LIKE '%$search%' OR a.account_no LIKE '%$search%')";
}

$query .= "
GROUP BY a.id
ORDER BY $sort ASC
";

$result = mysqli_query($conn,$query);
}
?>

<style>
.filter-card{
background:white;
padding:15px;
border-radius:18px;
box-shadow:0 6px 15px rgba(0,0,0,.08);
margin-bottom:15px;
}
.customer-card{
background:white;
border-radius:18px;
padding:15px;
margin-bottom:12px;
box-shadow:0 4px 12px rgba(0,0,0,.06);
}
.customer-name{
font-weight:600;
font-size:15px;
}
.badge-balance{
background:#e7f1ff;
color:#0d6efd;
font-weight:600;
padding:6px 10px;
border-radius:10px;
font-size:12px;
}
</style>

<div class="container">

<h5 class="mb-3">Customers</h5>

<!-- FILTER -->
<div class="filter-card">
<form method="GET">

<div class="row g-2">

<div class="col-12">
<select name="ledger" class="form-select">
<option value="">All General Ledgers</option>
<?php while($l=mysqli_fetch_assoc($ledgers)){ ?>
<option value="<?=$l['id']?>" <?=($ledger_id==$l['id'])?'selected':''?>>
<?=$l['ledger_name']?>
</option>
<?php } ?>
</select>
</div>

<div class="col-6">
<select name="sort" class="form-select">
<option value="account_no" <?=($sort=='account_no')?'selected':''?>>Sort by Account</option>
<option value="name" <?=($sort=='name')?'selected':''?>>Sort by Name</option>
<option value="paid" <?=($sort=='paid')?'selected':''?>>Sort by Balance</option>
</select>
</div>

<div class="col-6">
<input type="text" name="search" class="form-control"
placeholder="Search Name / AC No" value="<?=$search?>">
</div>

<div class="col-12">
<button name="apply" value="1" class="btn btn-primary w-100">
Apply Filter
</button>
</div>

</div>
</form>
</div>

<!-- BEFORE APPLY MESSAGE -->
<?php if(!$show){ ?>
<div class="text-center text-muted mt-5">
Select filters and tap <b>Apply Filter</b> to view customers
</div>
<?php } ?>

<!-- CUSTOMER LIST -->
<?php if($show && $result && mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){
$balance=$row['total_amount']-$row['paid'];
?>

<div class="customer-card">

<div class="d-flex justify-content-between">
<div>
<div class="customer-name"><?=$row['name']?></div>
<small class="text-muted">AC: <?=$row['account_no']?></small>
</div>

<div class="badge-balance">
₹<?=number_format($balance,2)?>
</div>

</div>

<hr>

<div class="d-flex justify-content-between">
<small>Ledger: <?=$row['ledger_name']?></small>
<small>Installment Amount: ₹<?=$row['installment_amount']?></small>
</div>

</div>

<?php }} elseif($show){ ?>

<div class="text-center text-muted mt-4">
No customers found
</div>

<?php } ?>

</div>

<?php include "layout/footer.php"; ?>