<?php
include "../config/db.php";

$q = $_GET['q'];
$agent = $_GET['agent'];

$r = mysqli_query($conn,"
SELECT a.account_no, c.name
FROM accounts a
JOIN customers c ON c.id = a.customer_id
WHERE c.agent_id='$agent'
AND (a.account_no LIKE '%$q%' OR c.name LIKE '%$q%')
LIMIT 10
");

$data=[];
while($row=mysqli_fetch_assoc($r)){
    $data[]=$row;
}

echo json_encode($data);
?>