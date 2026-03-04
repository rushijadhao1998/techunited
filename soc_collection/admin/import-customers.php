<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

// get agents for dropdown
$agents = mysqli_query($conn, "SELECT id,name FROM agents WHERE status='active'");

if (isset($_POST['import'])) {

    $agent_id = $_POST['agent_id'];

    // find branch of agent
    $a = mysqli_fetch_assoc(mysqli_query($conn, "SELECT branch_id FROM agents WHERE id='$agent_id'"));
    $branch_id = $a['branch_id'];

    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");

    // skip first 2 header lines
    fgetcsv($handle);
    fgetcsv($handle);

    $count = 0;
    $newcust = 0;

    while (($row = fgetcsv($handle)) !== FALSE) {

        $glid = trim($row[0]);
        $glid = preg_replace('/[^0-9]/', '', $glid);         // GLID
        $acid = trim($row[1]);
        $acid = preg_replace('/[^0-9]/', '', $acid);        // Account No
        $name = trim($row[2]);
        $date = date('Y-m-d', strtotime($row[3]));
        $balance = trim($row[4]);
        $inst = trim($row[5]);
        $mobile = trim($row[6]);
        $address = trim($row[8]);

        // find ledger
        $gl = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM gl_master WHERE glid='$glid'"));
        if (!$gl) continue;
        $gl_id = $gl['id'];

        // check customer exists by account number
        $cust = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM customers WHERE customer_code='$acid'"));

        if (!$cust) {
            mysqli_query($conn, "INSERT INTO customers(branch_id,agent_id,customer_code,name,mobile,address,join_date,status)
            VALUES('$branch_id','$agent_id','$acid','$name','$mobile','$address','$date','active')");

            $customer_id = mysqli_insert_id($conn);
            $newcust++;
        } else {
            $customer_id = $cust['id'];
        }

        // check account exists
        $check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM accounts WHERE account_no='$acid'"));

        if ($check) {
            // Account exists → update opening balance
            mysqli_query($conn, "
    UPDATE accounts 
    SET opening_balance='$balance',
        installment_amount='$inst',
        total_amount='$balance'
    WHERE account_no='$acid'
    ");

            $count++;
        } else {
            // Create new account
            mysqli_query($conn, "
    INSERT INTO accounts(account_no,customer_id,gl_id,open_date,installment_amount,total_amount,opening_balance)
    VALUES('$acid','$customer_id','$gl_id','$date','$inst','$balance','$balance')
    ");

            $count++;
        }
    }

    echo "<script>alert('Imported $count accounts & $newcust new customers');</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Import Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 col-md-6 mx-auto">

            <h3>Import Customer Excel</h3>

            <form method="POST" enctype="multipart/form-data">

                <label>Select Agent (Owner of passbooks)</label>
                <select name="agent_id" class="form-control mb-3" required>
                    <option value="">Choose Agent</option>
                    <?php while ($a = mysqli_fetch_assoc($agents)) { ?>
                        <option value="<?php echo $a['id']; ?>"><?php echo $a['name']; ?></option>
                    <?php } ?>
                </select>

                <input type="file" name="file" class="form-control mb-3" required>
                <button name="import" class="btn btn-primary w-100">Import</button>

            </form>

            <br>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>

        </div>
    </div>
</body>

</html>