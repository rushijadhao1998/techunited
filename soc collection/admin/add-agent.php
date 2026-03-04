<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

// fetch branches
$branches = mysqli_query($conn, "SELECT id,branch_name FROM branches WHERE status='active'");

if (isset($_POST['save'])) {
    $branch = $_POST['branch'];
    $agent_code = $_POST['agent_code'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check duplicate agent code
$codecheck=mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM agents WHERE agent_code='$agent_code'"));

if($codecheck)
{
    echo "<script>alert('Agent Code already exists!');</script>";
}
else
{
    // check duplicate username
    $usercheck=mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM agents WHERE username='$username'"));

    if($usercheck)
    {
        echo "<script>alert('Username already exists! Choose different username');</script>";
    }
    else
    {
        mysqli_query($conn,"INSERT INTO agents(branch_id,agent_code,name,mobile,username,password)
        VALUES('$branch','$agent_code','$name','$mobile','$username','$password')");

        echo "<script>alert('Agent Added Successfully');window.location='agent-list.php';</script>";
    }
}
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Agent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card p-4 col-md-6 mx-auto">

            <h3>Add Agent</h3>

            <form method="POST">

                <label>Branch</label>
                <select name="branch" class="form-control mb-3" required>
                    <option value="">Select Branch</option>
                    <?php while ($b = mysqli_fetch_assoc($branches)) { ?>
                        <option value="<?php echo $b['id']; ?>"><?php echo $b['branch_name']; ?></option>
                    <?php } ?>
                </select>

                <label>Agent Code</label>
                <input type="text" name="agent_code" class="form-control mb-3" required>

                <label>Name</label>
                <input type="text" name="name" class="form-control mb-3" required>

                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control mb-3" required>

                <label>Username</label>
                <input type="text" name="username" class="form-control mb-3" required>

                <label>Password</label>
                <input type="text" name="password" class="form-control mb-3" required>

                <button name="save" class="btn btn-primary w-100">Save Agent</button>

            </form>

            <br>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>

        </div>
    </div>

</body>

</html>