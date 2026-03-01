<?php
$agent = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT name,photo FROM agents WHERE id='{$_SESSION['agent_id']}'
"));
?>

<div class="sidebar">

<div class="profile">
    <img src="../assets/images/<?=$agent['photo'] ?? 'default.png'?>">
    <h6><?=$agent['name']?></h6>
    <!-- <small>Field Agent</small> -->
</div>

<a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
<a href="customers.php"><i class="bi bi-people"></i> Customers</a>
<a href="transaction.php"><i class="bi bi-cash-coin"></i> Transaction</a>
<a href="balance-statement.php"><i class="bi bi-wallet2"></i> Balance Statement</a>
<a href="agent-statement.php"><i class="bi bi-file-earmark-text"></i> Agent Statement</a>
<a href="datewise-statement.php"><i class="bi bi-calendar-day"></i> Datewise Statement</a>
<a href="agent-account-statement.php"><i class="bi bi-journal-text"></i> Agent Account Statement</a>
<a href="paid-unpaid.php"><i class="bi bi-check2-square"></i> Paid / Unpaid</a>
<a href="interest-calculation.php"><i class="bi bi-percent"></i> Interest Calculation</a>
<a href="dashboard.php"><i class="bi bi-arrow-clockwise"></i> Refresh</a>
<a href="profile.php"><i class="bi bi-person"></i> Profile</a>
<a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>

</div>

<div class="content">