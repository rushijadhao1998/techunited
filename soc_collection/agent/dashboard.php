<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";
?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Agent Dashboard</h5>
    <div class="text-muted fw-semibold">
        <?=date('d M Y')?>
    </div>
</div>

<div class="row g-3">

<div class="col-6">
<div class="cardbox">
<i class="bi bi-cash-coin fs-3 text-primary"></i>
<h6 class="mt-2">Create Transaction</h6>
<a href="transaction.php" class="btn btn-sm btn-primary w-100">Open</a>
</div>
</div>

<div class="col-6">
<div class="cardbox">
<i class="bi bi-wallet2 fs-3 text-success"></i>
<h6 class="mt-2">Balance Statement</h6>
<a href="balance-statement.php" class="btn btn-sm btn-success w-100">View</a>
</div>
</div>

<div class="col-6">
<div class="cardbox">
<i class="bi bi-file-earmark-text fs-3 text-warning"></i>
<h6 class="mt-2">Agent Statement</h6>
<a href="agent-statement.php" class="btn btn-sm btn-warning w-100">View</a>
</div>
</div>

<div class="col-6">
<div class="cardbox">
<i class="bi bi-people fs-3 text-info"></i>
<h6 class="mt-2">Customers</h6>
<a href="customers.php" class="btn btn-sm btn-info w-100">Open</a>
</div>
</div>

<div class="col-12">
<div class="cardbox">
<i class="bi bi-journal-text fs-3 text-dark"></i>
<h6 class="mt-2">Agent Account Statement</h6>
<a href="agent-account-statement.php" class="btn btn-sm btn-dark w-100">Open</a>
</div>
</div>

</div>

</div>

<?php include "layout/footer.php"; ?>