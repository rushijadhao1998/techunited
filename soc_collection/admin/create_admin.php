<?php
include "../config/db.php";


$pass=password_hash("admin123",PASSWORD_DEFAULT);

mysqli_query($conn,"INSERT INTO admin(username,password) VALUES('admin','$pass')");

echo "Admin Created";
?>