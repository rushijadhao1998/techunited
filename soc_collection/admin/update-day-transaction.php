<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id=$_POST['id'];
$amount=$_POST['amount'];

mysqli_query($conn,"UPDATE transactions SET amount='$amount' WHERE id='$id'");

$branch=$_GET['branch'];
$ledger=$_GET['ledger'];
$agent=$_GET['agent'];
$from=$_GET['from'];
$to=$_GET['to'];
$type=$_GET['type'];
$order=$_GET['order'];
$date=$_GET['date'];

/* return with success flag */
header("Location: edit-day-transactions.php?agent=$agent&date=$date&branch=$branch&ledger=$ledger&from=$from&to=$to&type=$type&order=$order&success=1");
exit;
?>