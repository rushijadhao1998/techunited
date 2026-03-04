<?php
session_start();
include "../config/db.php";

$id=$_POST['id'];
$date=$_POST['date'];
$amount=$_POST['amount'];

mysqli_query($conn,"UPDATE transactions SET collect_date='$date', amount='$amount' WHERE id='$id'");

/* return back to statement */
$branch=$_GET['branch'];
$ledger=$_GET['ledger'];
$agent=$_GET['agent'];
$from=$_GET['from'];
$to=$_GET['to'];
$type=$_GET['type'];
$order=$_GET['order'];

header("Location: agent-statement.php?show=1&branch=$branch&ledger=$ledger&agent=$agent&from=$from&to=$to&type=$type&order=$order&updatedOne=1");
exit;
?>