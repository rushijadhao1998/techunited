<?php
include "../config/db.php";

$branch = $_GET['branch'];

$q=mysqli_query($conn,"
SELECT id,name 
FROM agents 
WHERE branch_id='$branch' 
AND status='active'
ORDER BY name ASC
");

$data=[];
while($r=mysqli_fetch_assoc($q)){
    $data[]=$r;
}

echo json_encode($data);
?>