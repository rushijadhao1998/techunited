<?php
session_start();
include "../config/db.php";


/* defaults */
$branch_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM branches WHERE status='active' LIMIT 1"))['id'];
$ledger_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM gl_master WHERE status='active' LIMIT 1"))['id'];
$agent_id  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM agents WHERE status='active' LIMIT 1"))['id'];

$date = date('Y-m-d');

/* save */
/* save */
if (isset($_POST['save'])) {

    $account = $_POST['account'];
    $amount  = $_POST['amount'];
    $agent   = $_POST['agent'];
    $date    = $_POST['date'];

    $acc = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT a.id
FROM accounts a
JOIN customers c ON c.id=a.customer_id
WHERE a.account_no='$account'
AND c.agent_id='$agent'
"));

    if ($acc) {
        mysqli_query($conn, "INSERT INTO transactions(account_id,agent_id,amount,collect_date)
        VALUES('{$acc['id']}','$agent','$amount','$date')");

        $_SESSION['msg'] = "success";
    } else {
        $_SESSION['msg'] = "error";
    }

    header("Location: transaction-entry.php");
    exit;
}
include "layout/header.php";
include "layout/sidebar.php";
?>

<h3 class="mb-4">Transaction Entry</h3>

<form method="POST" class="row g-3" id="txnForm">

    <div class="col-md-3">
        <label>Branch</label>
        <select name="branch" class="form-control">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM branches WHERE status='active'");
            while ($b = mysqli_fetch_assoc($q)) {
            ?>
                <option value="<?= $b['id'] ?>" <?= $b['id'] == $branch_id ? 'selected' : '' ?>><?= $b['branch_name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-3">
        <label>Ledger</label>
        <select name="ledger" class="form-control">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM gl_master WHERE status='active'");
            while ($l = mysqli_fetch_assoc($q)) {
            ?>
                <option value="<?= $l['id'] ?>" <?= $l['id'] == $ledger_id ? 'selected' : '' ?>><?= $l['ledger_name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-3">
        <label>Agent</label>
        <select name="agent" class="form-control">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM agents WHERE status='active'");
            while ($a = mysqli_fetch_assoc($q)) {
            ?>
                <option value="<?= $a['id'] ?>" <?= $a['id'] == $agent_id ? 'selected' : '' ?>><?= $a['name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-3">
        <label>Date</label>
        <input type="date" name="date" value="<?= $date ?>" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Account No / Customer Name</label>
        <input type="text" id="searchAccount" class="form-control" placeholder="Type account no or name">
        <input type="hidden" name="account" id="account_id">
    </div>

    <div class="col-md-6">
        <label>Customer</label>
        <input type="text" id="customerName" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label>Amount</label>
        <input type="number" name="amount" class="form-control" required>
    </div>

    <div class="col-md-12">
        <button name="save" class="btn btn-success">Save Transaction</button>
    </div>

</form>

<!-- search result -->
<div id="resultBox" class="list-group mt-2"></div>

<script>
    /* SEARCH CUSTOMER */
    document.getElementById("searchAccount").addEventListener("keyup", function() {
        let q = this.value;

        if (q.length < 2) {
            document.getElementById("resultBox").innerHTML = "";
            return;
        }

        let agent = document.querySelector('[name="agent"]').value;
        fetch(`search-account.php?q=${q}&agent=${agent}`)
            .then(res => res.json())
            .then(data => {
                let html = "";

                data.forEach(row => {
                    html += `<a href="#" class="list-group-item list-group-item-action"
            onclick="selectCustomer('${row.account_no}','${row.name}')">
            ${row.account_no} - ${row.name}
            </a>`;
                });

                document.getElementById("resultBox").innerHTML = html;
            });
    });


    /* WHEN CUSTOMER CLICK */
    function selectCustomer(account, name) {
        document.getElementById("account_id").value = account;
        document.getElementById("customerName").value = name;
        document.getElementById("searchAccount").value = account + " - " + name;
        document.getElementById("resultBox").innerHTML = "";
    }


    /* STOP SAVE IF CUSTOMER NOT SELECTED */
    document.getElementById("txnForm").addEventListener("submit", function(e) {

        if (document.getElementById("account_id").value == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Select Customer',
                text: 'Please choose customer from suggestion list'
            });
            e.preventDefault();
        }

    });
</script>


<?php if (isset($_SESSION['msg'])) { ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            <?php if ($_SESSION['msg'] == "success") { ?>

                Swal.fire({
                    icon: 'success',
                    title: 'Transaction Saved!',
                    text: 'Entry Recorded Successfully',
                    confirmButtonColor: '#3085d6'
                });

            <?php } else { ?>

                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Account',
                    text: 'Please select customer from suggestion list'
                });

            <?php } ?>

        });
    </script>

<?php unset($_SESSION['msg']);
} ?>

<?php include "layout/footer.php"; ?>