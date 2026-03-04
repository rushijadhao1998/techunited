<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$agent = $_GET['agent'];
$date = $_GET['date'];

$branch = $_GET['branch'] ?? '';
$ledger = $_GET['ledger'] ?? '';
$from   = $_GET['from'] ?? date('Y-m-d');
$to     = $_GET['to'] ?? date('Y-m-d');
$type   = $_GET['type'] ?? '2';
$order  = $_GET['order'] ?? 'account_no';


$q = mysqli_query($conn, "
SELECT t.*, a.account_no, c.name
FROM transactions t
JOIN accounts a ON a.id=t.account_id
JOIN customers c ON c.id=a.customer_id
WHERE t.agent_id='$agent'
AND t.collect_date='$date'
");



?>

<h3>Edit Collections - <?= $date ?></h3>

<?php if (isset($_GET['updated'])) { ?>
    <div class="alert alert-success alert-dismissible fade show">
        Entry Updated Successfully ✔
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php } ?>

<table class="table table-bordered">
    <tr class="table-dark">
        <th>Account</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Update</th>
    </tr>

    <?php while ($r = mysqli_fetch_assoc($q)) { ?>
        <tr>
            <form method="POST" action="update-day-transaction.php?agent=<?= $agent ?>&date=<?= $date ?>&branch=<?= $branch ?>&ledger=<?= $ledger ?>&from=<?= $from ?>&to=<?= $to ?>&type=<?= $type ?>&order=<?= $order ?>">
                <input type="hidden" name="id" value="<?= $r['id'] ?>">

                <td><?= $r['account_no'] ?></td>
                <td><?= $r['name'] ?></td>

                <td>
                    <input type="number" name="amount" value="<?= $r['amount'] ?>" class="form-control">
                </td>

                <td>
                    <button class="btn btn-success btn-sm">Save</button>
                </td>
            </form>
        </tr>
    <?php } ?>
</table>

<a href="agent-statement.php?show=1&branch=<?= $branch ?>&ledger=<?= $ledger ?>&agent=<?= $agent ?>&from=<?= $from ?>&to=<?= $to ?>&type=<?= $type ?>&order=<?= $order ?>" class="btn btn-secondary">Back</a>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Success</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

<?php if(isset($_GET['success'])){ ?>
<script>
document.addEventListener("DOMContentLoaded", function(){
    var myModal = new bootstrap.Modal(document.getElementById('successModal'));
    myModal.show();
});
</script>
<?php } ?>

<?php include "layout/footer.php"; ?>