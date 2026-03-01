<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

// stats
$totalCustomers=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as c FROM customers WHERE status='active'"))['c'];
$totalAccounts=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as c FROM accounts WHERE status='active'"))['c'];
$today=date('Y-m-d');
$todayCollection=mysqli_fetch_assoc(mysqli_query($conn,"SELECT IFNULL(SUM(amount),0) as t FROM transactions WHERE collect_date='$today'"))['t'];
$agents=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as c FROM agents WHERE status='active'"))['c'];
?>



<h3 class="mb-4">Dashboard Overview</h3>

<div class="row g-4">
<div class="col-md-3">
<div class="card card-box p-3 text-center bg-primary text-white">
<h2><?php echo $totalCustomers; ?></h2>
Customers
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3 text-center bg-success text-white">
<h2><?php echo $totalAccounts; ?></h2>
Accounts
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3 text-center bg-warning text-dark">
<h2>₹<?php echo $todayCollection; ?></h2>
Today's Collection
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3 text-center bg-info text-white">
<h2><?php echo $agents; ?></h2>
Active Agents
</div>
</div>
</div>

<?php include "layout/footer.php"; ?>