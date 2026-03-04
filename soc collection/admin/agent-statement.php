<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

/* ---------- DEFAULT VALUES ---------- */

// first branch
$branch_id = $_GET['branch'] ?? mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM branches WHERE status='active' LIMIT 1"))['id'];

// first ledger
$ledger_id = $_GET['ledger'] ?? mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM gl_master WHERE status='active' LIMIT 1"))['id'];

// first agent
$agent_id = $_GET['agent'] ?? mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM agents WHERE status='active' LIMIT 1"))['id'];

$from = $_GET['from'] ?? date('Y-m-d');
$to   = $_GET['to'] ?? date('Y-m-d');

$order = $_GET['order'] ?? 'account_no';
$type  = $_GET['type'] ?? '1';

$show = isset($_GET['show']);
?>

<h3 class="mb-4">Agent Statement</h3>

<form method="GET" class="row g-3 mb-4">

<div class="col-md-2">
<label>Branch</label>
<select name="branch" class="form-control">
<?php
$bq=mysqli_query($conn,"SELECT * FROM branches WHERE status='active'");
while($b=mysqli_fetch_assoc($bq)){ ?>
<option value="<?=$b['id']?>" <?=$branch_id==$b['id']?'selected':''?>>
<?=$b['branch_name']?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-2">
<label>Ledger</label>
<select name="ledger" class="form-control">
<?php
$lq=mysqli_query($conn,"SELECT * FROM gl_master WHERE status='active'");
while($l=mysqli_fetch_assoc($lq)){ ?>
<option value="<?=$l['id']?>" <?=$ledger_id==$l['id']?'selected':''?>>
<?=$l['ledger_name']?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-2">
<label>Agent</label>
<select name="agent" class="form-control">
<?php
$aq=mysqli_query($conn,"SELECT * FROM agents WHERE status='active'");
while($a=mysqli_fetch_assoc($aq)){ ?>
<option value="<?=$a['id']?>" <?=$agent_id==$a['id']?'selected':''?>>
<?=$a['name']?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-2">
<label>From Date</label>
<input type="date" name="from" value="<?=$from?>" class="form-control">
</div>

<div class="col-md-2">
<label>To Date</label>
<input type="date" name="to" value="<?=$to?>" class="form-control">
</div>

<div class="col-md-1">
<label>Order</label>
<select name="order" class="form-control">
<option value="account_no" <?=$order=='account_no'?'selected':''?>>AC No</option>
<option value="name" <?=$order=='name'?'selected':''?>>Name</option>
</select>
</div>

<div class="col-md-1">
<label>Type</label>
<select name="type" class="form-control">
<option value="1" <?=$type=='1'?'selected':''?>>I</option>
<option value="2" <?=$type=='2'?'selected':''?>>II</option>
</select>
</div>

<div class="col-md-12">
<button name="show" class="btn btn-primary">Show Statement</button>
</div>

</form>

<?php if($show){ ?>

<?php if($type==1){ ?>

<!-- TYPE I : Detailed -->
<table class="table table-bordered table-sm">
<tr class="table-dark">
<th>Date</th>
<th>Account No</th>
<th>Name</th>
<th>Installment</th>
<th>Amount</th>
<th>Action</th>
</tr>

<?php
$q=mysqli_query($conn,"
SELECT t.id, t.collect_date, a.account_no, c.name, a.installment_amount, t.amount
FROM transactions t
JOIN accounts a ON a.id=t.account_id
JOIN customers c ON c.id=a.customer_id
WHERE a.branch_id='$branch_id'
AND a.gl_id='$ledger_id'
AND t.agent_id='$agent_id'
AND t.collect_date BETWEEN '$from' AND '$to'
ORDER BY $order
");

$total=0;
while($r=mysqli_fetch_assoc($q)){
$total+=$r['amount'];
?>
<tr>
<td><?=$r['collect_date']?></td>
<td><?=$r['account_no']?></td>
<td><?=$r['name']?></td>
<td><?=$r['installment_amount']?></td>
<td>₹<?=$r['amount']?></td>

<td>
<button 
class="btn btn-sm btn-primary editEntryBtn"
data-id="<?=$r['id']?>"
data-date="<?=$r['collect_date']?>"
data-amount="<?=$r['amount']?>"
data-account="<?=$r['account_no']?>"
data-name="<?=$r['name']?>">
Edit
</button>

<button 
class="btn btn-sm btn-danger deleteEntryBtn"
data-id="<?=$r['id']?>"
data-branch="<?=$branch_id?>"
data-ledger="<?=$ledger_id?>"
data-agent="<?=$agent_id?>"
data-from="<?=$from?>"
data-to="<?=$to?>"
data-type="<?=$type?>"
data-order="<?=$order?>">
Delete
</button>
</td>
</tr>
<?php } ?>

<tr class="table-success">
<td colspan="4"><b>Total</b></td>
<td><b>₹<?=$total?></b></td>
</tr>

</table>

<?php } else { ?>

<!-- TYPE II : Summary -->
<table class="table table-bordered">
<tr class="table-dark">
<th>Date</th>
<th>Total Collection</th>
<th>Action</th>
</tr>

<?php
$q=mysqli_query($conn,"
SELECT collect_date, SUM(amount) total
FROM transactions
WHERE agent_id='$agent_id'
AND collect_date BETWEEN '$from' AND '$to'
GROUP BY collect_date
ORDER BY collect_date
");

$grand=0;
while($r=mysqli_fetch_assoc($q)){
$grand+=$r['total'];
?>
<tr>

<td><?=$r['collect_date']?></td>
<td>₹<?=$r['total']?></td>

<td>
<a href="edit-day-transactions.php?agent=<?=$agent_id?>&date=<?=$r['collect_date']?>&branch=<?=$branch_id?>&ledger=<?=$ledger_id?>&from=<?=$from?>&to=<?=$to?>&type=<?=$type?>&order=<?=$order?>"
class="btn btn-sm btn-primary">Edit</a>

<button 
class="btn btn-sm btn-danger deleteDayBtn"
data-agent="<?=$agent_id?>"
data-date="<?=$r['collect_date']?>"
data-branch="<?=$branch_id?>"
data-ledger="<?=$ledger_id?>"
data-from="<?=$from?>"
data-to="<?=$to?>"
data-type="<?=$type?>"
data-order="<?=$order?>">
Delete All
</button>
</td>

</tr>
<?php } ?>

<tr class="table-success">
<td><b>Grand Total</b></td>
<td><b>₹<?=$grand?></b></td>
</tr>

</table>

<?php } ?>

<?php } ?>


<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <h5>Delete ALL collections of this date?</h5>
        <p class="text-danger">This action cannot be undone</p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</a>
      </div>

    </div>
  </div>
</div>

<script>
document.querySelectorAll(".deleteDayBtn").forEach(btn=>{
    btn.addEventListener("click", function(){

        let agent=this.dataset.agent;
        let date=this.dataset.date;
        let branch=this.dataset.branch;
        let ledger=this.dataset.ledger;
        let from=this.dataset.from;
        let to=this.dataset.to;
        let type=this.dataset.type;
        let order=this.dataset.order;

        let url=`delete-day-transactions.php?agent=${agent}&date=${date}&branch=${branch}&ledger=${ledger}&from=${from}&to=${to}&type=${type}&order=${order}`;

        document.getElementById("confirmDeleteBtn").href=url;

        var modal=new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    });
});
</script>


<!-- Delete Success Modal -->
<div class="modal fade" id="deletedModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Deleted</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <h5>All Entries Deleted Successfully ✔</h5>
      </div>

      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>

    </div>
  </div>
</div>

<?php if(isset($_GET['deleted'])){ ?>
<script>
document.addEventListener("DOMContentLoaded", function(){
    new bootstrap.Modal(document.getElementById('deletedModal')).show();
});
</script>
<?php } ?>


<!-- Single Delete Modal -->
<div class="modal fade" id="deleteEntryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <h5>Delete this entry?</h5>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmSingleDelete" class="btn btn-danger">Yes Delete</a>
      </div>

    </div>
  </div>
</div>

<script>
document.querySelectorAll(".deleteEntryBtn").forEach(btn=>{
    btn.addEventListener("click", function(){

        let id=this.dataset.id;
        let branch=this.dataset.branch;
        let ledger=this.dataset.ledger;
        let agent=this.dataset.agent;
        let from=this.dataset.from;
        let to=this.dataset.to;
        let type=this.dataset.type;
        let order=this.dataset.order;

        let url=`delete-transaction.php?id=${id}&branch=${branch}&ledger=${ledger}&agent=${agent}&from=${from}&to=${to}&type=${type}&order=${order}`;

        document.getElementById("confirmSingleDelete").href=url;

        new bootstrap.Modal(document.getElementById('deleteEntryModal')).show();
    });
});
</script>

<div class="modal fade" id="deletedOneModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Deleted</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <h5>Entry Deleted Successfully ✔</h5>
      </div>

      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>

    </div>
  </div>
</div>

<?php if(isset($_GET['deletedOne'])){ ?>
<script>
document.addEventListener("DOMContentLoaded", function(){
    new bootstrap.Modal(document.getElementById('deletedOneModal')).show();
});
</script>
<?php } ?>


<!-- Edit Entry Modal -->
<div class="modal fade" id="editEntryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form method="POST" action="update-single-transaction.php?branch=<?=$branch_id?>&ledger=<?=$ledger_id?>&agent=<?=$agent_id?>&from=<?=$from?>&to=<?=$to?>&type=<?=$type?>&order=<?=$order?>">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit Collection</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <input type="hidden" name="id" id="edit_id">

        <div class="mb-2">
          <label>Account</label>
          <input type="text" id="edit_account" class="form-control" readonly>
        </div>

        <div class="mb-2">
          <label>Name</label>
          <input type="text" id="edit_name" class="form-control" readonly>
        </div>

        <div class="mb-2">
          <label>Date</label>
          <input type="date" name="date" id="edit_date" class="form-control">
        </div>

        <div class="mb-2">
          <label>Amount</label>
          <input type="number" name="amount" id="edit_amount" class="form-control">
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-success">Update</button>
      </div>

      </form>

    </div>
  </div>
</div>

<script>
document.querySelectorAll(".editEntryBtn").forEach(btn=>{
    btn.addEventListener("click", function(){

        document.getElementById("edit_id").value=this.dataset.id;
        document.getElementById("edit_date").value=this.dataset.date;
        document.getElementById("edit_amount").value=this.dataset.amount;
        document.getElementById("edit_account").value=this.dataset.account;
        document.getElementById("edit_name").value=this.dataset.name;

        new bootstrap.Modal(document.getElementById('editEntryModal')).show();
    });
});
</script>


<div class="modal fade" id="updatedOneModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Updated</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <h5>Entry Updated Successfully ✔</h5>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<?php if(isset($_GET['updatedOne'])){ ?>
<script>
document.addEventListener("DOMContentLoaded", function(){
    new bootstrap.Modal(document.getElementById('updatedOneModal')).show();
});
</script>
<?php } ?>

<?php include "layout/footer.php"; ?>