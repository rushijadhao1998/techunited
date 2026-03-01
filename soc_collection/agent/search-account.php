<?php
session_start();
include "../config/db.php";

$agent=$_SESSION['agent_id'];
$q=$_GET['q'];
$ledger=$_GET['ledger'];
$date=$_GET['date'];

$result=mysqli_query($conn,"
SELECT a.id,a.account_no,c.name
FROM accounts a
JOIN customers c ON c.id=a.customer_id
WHERE c.agent_id='$agent'
AND a.gl_id='$ledger'
AND (c.name LIKE '%$q%' OR a.account_no LIKE '%$q%')
LIMIT 10
");

while($r=mysqli_fetch_assoc($result)){
echo "
<a href='collect.php?acc={$r['id']}&date=$date&ledger=$ledger' 
class='list-group-item list-group-item-action'>
{$r['account_no']} - {$r['name']}
</a>";
}