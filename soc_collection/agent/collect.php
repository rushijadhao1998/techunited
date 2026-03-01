<?php
session_start();
include "../config/db.php";
include "../config/sms.php";
include "layout/header.php";
include "layout/sidebar.php";

if (!isset($_SESSION['agent_id'])) {
    header("Location: login.php");
    exit;
}

$agent_id = $_SESSION['agent_id'];
$acc_id = $_GET['acc'] ?? 0;

/* GET CUSTOMER DATA WITH CORRECT FORMULA */
$data = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT 
a.id,
a.account_no,
a.installment_amount,
a.open_date,
c.name,
c.mobile,
c.address,
gl.ledger_name,
IFNULL(SUM(t.amount),0) AS balance
FROM accounts a
JOIN customers c ON c.id=a.customer_id
JOIN gl_master gl ON gl.id=a.gl_id
LEFT JOIN transactions t ON t.account_id=a.id
WHERE a.id='$acc_id'
GROUP BY a.id
"));

if (!$data) {
    echo "<div class='container mt-5 text-danger'>Customer Not Found</div>";
    exit;
}

/* FINAL BALANCE FORMULA */
$total_balance = $data['opening_balance'] + $data['collected'];

/* SAVE COLLECTION */
if (isset($_POST['collect'])) {
    $amount = $_POST['amount'];
    $today = date('Y-m-d');

    if ($amount > 0) {
        /* CHECK TODAY COLLECTION */
        $check = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT id FROM transactions
        WHERE account_id='$acc_id'
        AND collect_date='$today'
        LIMIT 1
        "));

        if ($check) {
            echo "<script>
            Swal.fire({
                icon:'warning',
                title:'Already Collected',
                text:'Today Collection Already Done For This Customer'
            });
            </script>";
        } else {

            mysqli_query($conn, "
INSERT INTO transactions(account_id,agent_id,amount,collect_date)
VALUES('$acc_id','$agent_id','$amount','$today')
");

            /* NEW BALANCE CALCULATION */
            $new_balance = $data['total_balance'] + $amount;

            /* SEND SMS */
            sendSMS(
                $data['mobile'],
                $amount,
                $data['ledger_name'],
                $data['account_no'],
                date('d-m-Y'),
                $new_balance
            );

            echo "<script>
            Swal.fire({
                icon:'success',
                title:'Collection Saved',
                text:'Amount Added to Total Balance'
            }).then(()=>{window.location='collect.php?acc=$acc_id';});
            </script>";
        }
    }
}
?>

<style>
    .card-box {
        background: #fff;
        border-radius: 18px;
        padding: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
        margin-bottom: 15px;
    }

    .label {
        font-size: 13px;
        color: #6c757d
    }

    .value {
        font-weight: 600
    }

    .big-input {
        height: 60px;
        font-size: 22px;
        text-align: center;
        font-weight: bold;
    }

    .balance {
        background: #e3f2fd;
        color: #0d6efd;
        padding: 12px;
        border-radius: 12px;
        text-align: center;
        font-weight: 700;
        font-size: 22px;
    }


    .rupee-input {
        position: relative;
    }

    .rupee {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        font-weight: 600;
        color: #198754;
    }

    .amount-field {
        height: 60px;
        font-size: 22px;
        font-weight: bold;
        padding-left: 40px;
        text-align: left;
    }
</style>

<div class="container">

    <h5 class="mb-3">Collect Amount</h5>

    <!-- CUSTOMER DETAILS -->
    <div class="card-box">

        <div class="mb-2">
            <div class="value"><?= $data['name'] ?></div>
            <small class="text-muted">A/C: <?= $data['account_no'] ?></small>
        </div>

        <hr>

        <div class="row g-2">

            <div class="col-6">
                <div class="label">Installment Amount</div>
                <div class="value">₹<?= $data['installment_amount'] ?></div>
            </div>

            <div class="col-6">
                <div class="label">Join Date</div>
                <div class="value"><?= date('d-m-Y', strtotime($data['open_date'])) ?></div>
            </div>

            <div class="col-6">
                <div class="label">Previous Balance</div>
                <div class="value">₹<?= number_format($data['opening_balance'], 2) ?>
                </div>
            </div>

            <div class="col-6">
                <div class="label">Mobile Number</div>
                <div class="value"><?= $data['mobile'] ?></div>
            </div>

            <div class="col-6">
                <div class="label mt-2">Collected Amount</div>
                <div class="value">₹<?= number_format($data['collected'], 2) ?></div>
            </div>


            <div class="col-6">
                <div class="label">Address</div>
                <div class="value"><?= $data['address'] ?></div>
            </div>



            <div class="col-12 mt-2">
                <div class="label mt-2">Total Balance</div>
                <div class="balance">₹ <?= number_format($total_balance, 2) ?></div>
            </div>

        </div>

    </div>

    <!-- COLLECT FORM -->
    <div class="card-box">

        <form method="POST">

            <div class="mt-3">

                <label class="form-label fw-semibold">Enter Collect Amount</label>

                <div class="rupee-input">
                    <span class="rupee">₹</span>
                    <input type="number" name="amount" class="form-control amount-field" required>
                </div>

            </div>

            <div class="row mt-3 g-2">

                <div class="col-6">
                    <a href="transaction.php" class="btn btn-secondary w-100">
                        Back
                    </a>
                </div>

                <div class="col-6">
                    <button name="collect" class="btn btn-success w-100">
                        Confirm
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

<script>
    document.querySelector('.amount-field').focus();
</script>

<?php include "layout/footer.php"; ?>