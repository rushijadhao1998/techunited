<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// keep filters
$branch = $_GET['branch'];
$ledger = $_GET['ledger'];
$agent  = $_GET['agent'];
$from   = $_GET['from'];
$to     = $_GET['to'];
$type   = $_GET['type'];
$order  = $_GET['order'];

mysqli_query($conn,"DELETE FROM transactions WHERE id='$id'");

header("Location: agent-statement.php?show=1&branch=$branch&ledger=$ledger&agent=$agent&from=$from&to=$to&type=$type&order=$order&deletedOne=1");
exit;
?>