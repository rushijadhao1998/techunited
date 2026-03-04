<?php
include "../config/db.php";

$agent  = $_GET['agent'];
$ledger = $_GET['ledger'];
$from   = $_GET['from'];
$to     = $_GET['to'];

/* Agent Info */
$agentRow = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT agent_code,name FROM agents WHERE id='$agent'
"));

$filename = $agentRow['name']."(".$agentRow['agent_code'].")".date('dMY',strtotime($from)).".csv";

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

/* FIRST LINE — EXACT SAME FORMAT */
echo "\""."1,".$agentRow['agent_code'].",".$agentRow['name']."\"\n";

/* HEADER */
echo "GLID,Acid,Name,InstAmt,TransDate,Amount,Balance,\n";

/* DATA */
$q=mysqli_query($conn,"
SELECT 
gl.glid,
a.account_no,
c.name,
a.installment_amount,
t.collect_date,
t.amount
FROM transactions t
JOIN accounts a ON a.id=t.account_id
JOIN customers c ON c.id=a.customer_id
JOIN gl_master gl ON gl.id=a.gl_id
WHERE t.agent_id='$agent'
AND a.gl_id='$ledger'
AND t.collect_date BETWEEN '$from' AND '$to'
ORDER BY t.collect_date,a.account_no
");

while($r=mysqli_fetch_assoc($q))
{
$date=date('d/m/Y',strtotime($r['collect_date']));

echo $r['glid'].",".
     $r['account_no'].",".
     str_replace(',',' ',$r['name']).",".
     $r['installment_amount'].",".
     $date.",".
     $r['amount'].",\n";   // SINGLE COMMA like original file
}

exit;
?>