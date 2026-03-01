<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

$id = $_GET['id'];

// fetch agent
$agent = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM agents WHERE id='$id'"));

// fetch branches
$branches = mysqli_query($conn, "SELECT id,branch_name FROM branches");

if (isset($_POST['update'])) {
    $branch=$_POST['branch'];
$agent_code=$_POST['agent_code'];
$name=$_POST['name'];
$mobile=$_POST['mobile'];
$username=$_POST['username'];
$password=$_POST['password'];

if($password!='')
{
    $hash=password_hash($password,PASSWORD_DEFAULT);

    mysqli_query($conn,"UPDATE agents SET
    branch_id='$branch',
    agent_code='$agent_code',
    name='$name',
    mobile='$mobile',
    username='$username',
    password='$hash'
    WHERE id='$id'");
}
else
{
    mysqli_query($conn,"UPDATE agents SET
    branch_id='$branch',
    agent_code='$agent_code',
    name='$name',
    mobile='$mobile',
    username='$username'
    WHERE id='$id'");
}

    echo "<script>alert('Agent Updated');window.location='agent-list.php';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Agent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 col-md-6 mx-auto">

            <h3>Edit Agent</h3>

            <form method="POST">

                <label>Branch</label>
                <select name="branch" class="form-control mb-3">
                    <?php while ($b = mysqli_fetch_assoc($branches)) { ?>
                        <option value="<?php echo $b['id']; ?>"
                            <?php if ($agent['branch_id'] == $b['id']) echo 'selected'; ?>>
                            <?php echo $b['branch_name']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Agent Code</label>
                <input type="text" name="agent_code"
                    value="<?php echo $agent['agent_code']; ?>"
                    class="form-control mb-3">

                <label>Name</label>
                <input type="text" name="name" value="<?php echo $agent['name']; ?>" class="form-control mb-3">

                <label>Mobile</label>
                <input type="text" name="mobile" value="<?php echo $agent['mobile']; ?>" class="form-control mb-3">

                <label>Username</label>
                <input type="text" name="username" value="<?php echo $agent['username']; ?>" class="form-control mb-3">

                <label>New Password (leave blank to keep old)</label>
                <input type="text" name="password" class="form-control mb-3">

                <button name="update" class="btn btn-primary w-100">Update</button>

            </form>

            <br>
            <a href="agent-list.php" class="btn btn-secondary">Back</a>

        </div>
    </div>
</body>

</html>