<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

/* dropdowns */
$branches = mysqli_query($conn,"SELECT * FROM branches WHERE status='active' ORDER BY branch_name ASC");
$ledgers  = mysqli_query($conn,"SELECT * FROM gl_master WHERE status='active' ORDER BY ledger_name ASC");

/* selected filters */
$branch_id = $_GET['branch'] ?? '';
$agent_id  = $_GET['agent'] ?? '';
$ledger_id = $_GET['ledger'] ?? '';
$order     = $_GET['order'] ?? 'account_no';
$show      = isset($_GET['show']);

?>

<h3 class="mb-4">Customer Accounts</h3>

<div class="card shadow-sm mb-4">
<div class="card-body">

<form method="GET" class="row align-items-end g-3">

<div class="col-lg-3 col-md-6">
<label class="form-label fw-semibold">Branch</label>
<select name="branch" id="branchSelect" class="form-select" required>
<option value="">Select Branch</option>
<?php while($b=mysqli_fetch_assoc($branches)){ ?>
<option value="<?=$b['id']?>" <?=($branch_id==$b['id'])?'selected':''?>>
<?=$b['branch_name']?>
</option>
<?php } ?>
</select>
</div>

<div class="col-lg-3 col-md-6">
<label class="form-label fw-semibold">Agent</label>
<select name="agent" id="agentSelect" class="form-select" required>
<option value="">Select Agent</option>
</select>
</div>

<div class="col-lg-3 col-md-6">
<label class="form-label fw-semibold">Ledger</label>
<select name="ledger" class="form-select">
<option value="">All Ledger</option>
<?php while($l=mysqli_fetch_assoc($ledgers)){ ?>
<option value="<?=$l['id']?>" <?=($ledger_id==$l['id'])?'selected':''?>>
<?=$l['ledger_name']?>
</option>
<?php } ?>
</select>
</div>

<div class="col-lg-2 col-md-6">
<label class="form-label fw-semibold">Order By</label>
<select name="order" class="form-select">
<option value="account_no" <?=$order=='account_no'?'selected':''?>>Account No</option>
<option value="name" <?=$order=='name'?'selected':''?>>Customer Name</option>
</select>
</div>

<div class="col-lg-1 col-md-12 d-grid">
<button name="show" value="1" class="btn btn-primary">
<i class="bi bi-search"></i>
</button>
</div>

</form>
</div>
</div>

<?php
if($show && $agent_id!=''){

$query="
SELECT 
a.id,
a.account_no,
a.installment_amount,
a.total_amount,
a.status,
c.name,
c.mobile,
ag.agent_code,
gl.ledger_name,

(
a.opening_balance +
IFNULL((
SELECT SUM(t.amount)
FROM transactions t
WHERE t.account_id=a.id
),0)
) AS balance

FROM accounts a
JOIN customers c ON c.id=a.customer_id
JOIN agents ag ON ag.id=c.agent_id
JOIN gl_master gl ON gl.id=a.gl_id

WHERE c.agent_id='$agent_id'
";

if($ledger_id!=''){
$query.=" AND a.gl_id='$ledger_id'";
}

$query.=" ORDER BY $order ASC";

$result=mysqli_query($conn,$query);
?>

<table id="customerTable" class="table table-bordered table-hover">
<tr class="table-dark">
<th>Sr No</th>
<th>Agent Code</th>
<th>Ledger</th>
<th>Installment</th>
<th>Balance</th>

<th>ACID</th>
<th>Customer Name</th>
<th>Mobile</th>
<th>Status</th>
</tr>

<?php
$sr=1;
while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?=$sr++?></td>
<td><?=$row['agent_code']?></td>
<td><?=$row['ledger_name']?></td>
<td>₹<?=$row['installment_amount']?></td>

<td class="fw-bold text-primary">
₹<?=number_format($row['balance'],2)?>
</td>



<td><?=$row['account_no']?></td>
<td><?=$row['name']?></td>
<td><?=$row['mobile']?></td>

<td>
<?php if($row['status']=='active'){ ?>
<span class="badge bg-success">Active</span>
<?php } else { ?>
<span class="badge bg-danger">Closed</span>
<?php } ?>
</td>

</tr>
<?php } ?>
</table>

<?php } ?>

<script>
function loadAgents(branchId,selectedAgent=null){

if(branchId==""){
document.getElementById("agentSelect").innerHTML="<option value=''>Select Agent</option>";
return;
}

fetch("get-agents-by-branch.php?branch="+branchId)
.then(res=>res.json())
.then(data=>{
let html="<option value=''>Select Agent</option>";
data.forEach(a=>{
let sel=(selectedAgent==a.id)?"selected":"";
html+=`<option value="${a.id}" ${sel}>${a.name}</option>`;
});
document.getElementById("agentSelect").innerHTML=html;
});
}

/* branch change */
document.getElementById("branchSelect").addEventListener("change",function(){
loadAgents(this.value);
let table=document.getElementById("customerTable");
if(table) table.remove();
});

/* reload selected */
window.addEventListener("DOMContentLoaded",function(){
let branch="<?=$branch_id?>";
let agent="<?=$agent_id?>";
if(branch!="") loadAgents(branch,agent);
});
</script>

<?php include "layout/footer.php"; ?>