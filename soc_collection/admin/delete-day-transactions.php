<?php
session_start();
include "../config/db.php";

$agent=$_GET['agent'];
$date=$_GET['date'];

$branch=$_GET['branch'];
$ledger=$_GET['ledger'];
$from=$_GET['from'];
$to=$_GET['to'];
$type=$_GET['type'];
$order=$_GET['order'];

mysqli_query($conn,"DELETE FROM transactions WHERE agent_id='$agent' AND collect_date='$date'");

header("Location: agent-statement.php?show=1&branch=$branch&ledger=$ledger&agent=$agent&from=$from&to=$to&type=$type&order=$order&deleted=1");
exit;
?>