<?php
session_start();
include "../config/db.php";

$no = $_GET['no'];

$r = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT t.*, customers.name, accounts.account_no
FROM transactions t
JOIN accounts ON accounts.id=t.account_id
JOIN customers ON customers.id=accounts.customer_id
WHERE receipt_no='$no'
"));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial;
        }

        .receipt-box {
            width: 350px;
            margin: auto;
            border: 2px dashed #000;
            padding: 15px;
        }

        .logo {
            width: 70px;
        }

        @media print{
    .btn{ display:none; }
}
    </style>
</head>

<body>

    <div class="receipt-box">

        <div class="text-center">

            <img src="assets/logo.png" class="logo"><br>

            <h5><b>UNITED TECH CREDIT CO-OPERATIVE SOCIETY</b></h5>
            <small>Nagpur, Maharashtra<br>Ph: 8446590779</small>

            <hr>

            <h6><b>COLLECTION RECEIPT</b></h6>
        </div>

        <table class="table table-sm">
            <tr>
                <td>Receipt No</td>
                <td><?php echo $r['receipt_no']; ?></td>
            </tr>
            <tr>
                <td>Date</td>
                <td><?php echo $r['collect_date']; ?></td>
            </tr>
            <tr>
                <td>Account</td>
                <td><?php echo $r['account_no']; ?></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo $r['name']; ?></td>
            </tr>
        </table>

        <div class="text-center">
            <h3>₹<?php echo $r['amount']; ?></h3>
        </div>

        <hr>

        <div class="text-center">
            <small>Authorized Signature</small><br><br>
            _____________________
        </div>

        <p class="text-center mt-3"><small>Thank You</small></p>

    </div>

    <div class="text-center mt-3">
    <button onclick="window.print()" class="btn btn-primary">Print</button>
    <a href="accounts.php" class="btn btn-danger">Exit</a>
</div>

</body>

</html>