<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

/* dropdown data */
$agents  = mysqli_query($conn,"SELECT id,name FROM agents WHERE status='active' ORDER BY name");
$ledgers = mysqli_query($conn,"SELECT id,ledger_name FROM gl_master WHERE status='active' ORDER BY ledger_name");
?>

<div class="container mt-4">
<div class="card shadow-sm col-md-6">
<div class="card-header bg-light fw-bold">Export Transactions</div>

<div class="card-body">

<form method="GET" action="export-transactions-excel.php">

<div class="mb-3">
<label>Agent :</label>
<select name="agent" class="form-control" required>
<option value="">Select Agent</option>
<?php while($a=mysqli_fetch_assoc($agents)){ ?>
<option value="<?=$a['id']?>"><?=$a['name']?></option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label>General Ledger :</label>
<select name="ledger" class="form-control" required>
<option value="">Select Ledger</option>
<?php while($l=mysqli_fetch_assoc($ledgers)){ ?>
<option value="<?=$l['id']?>"><?=$l['ledger_name']?></option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label>From Date :</label>
<input type="date" name="from" class="form-control" value="<?=date('Y-m-d')?>" required>
</div>

<div class="mb-3">
<label>To Date :</label>
<input type="date" name="to" class="form-control" value="<?=date('Y-m-d')?>" required>
</div>

<button class="btn btn-success">
<i class="bi bi-file-earmark-excel"></i> Export
</button>

</form>

</div>
</div>
</div>

<?php include "layout/footer.php"; ?>