<?php
include "../config/db.php";

$agent = $_GET['agent'];

$r = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT b.branch_name, b.id
FROM agents a
JOIN branches b ON b.id = a.branch_id
WHERE a.id='$agent'
"));

echo json_encode($r);