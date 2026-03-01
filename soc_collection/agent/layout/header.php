<?php
if(!isset($_SESSION['agent_id'])){
    header("Location: agent-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Agent Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    margin:0;
    background:#f1f4f9;
    font-family:system-ui;
    overflow-x:hidden;
}

/* TOP NAV */
.topbar{
    background: linear-gradient(-45deg, #7a1030, #94096d);
    color:white;
    padding:12px 15px;
    display:flex;
    align-items:center;
    justify-content:space-around;
    text-align: center;
}

.topbar h6{
    margin:0;
    font-weight:600;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    top:0;
    left:-260px;
    width:250px;
    height:100vh;
    background:#0f172a;
    color:white;
    transition:.3s;
    z-index:1000;
    overflow-y:auto;
}

.sidebar.show{
    left:0;
}

.sidebar a{
    color:#cbd5e1;
    padding:12px 20px;
    display:block;
    text-decoration:none;
    font-size:15px;
}

.sidebar a:hover{
    background:#1e293b;
}

/* PROFILE */
.profile{
    text-align:center;
    padding:20px 10px;
    border-bottom:1px solid #334155;
}

.profile img{
    width:70px;
    height:70px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #3da5ff;
}

.profile h6{
    margin-top:10px;
    margin-bottom:0;
}

/* CONTENT */
.content{
    padding:15px;
}

/* CARD */
.cardbox{
    background:white;
    border-radius:18px;
    padding:15px;
    text-align:center;
    box-shadow:0 6px 15px rgba(0,0,0,.08);
}

/* FOOTER */
.footer{
    position:fixed;
    bottom:0;
    width:100%;
    background:white;
    border-top:1px solid #ddd;
    text-align:center;
    padding:8px;
    font-size:13px;
    color:#666;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="topbar">
    <button class="btn btn-light btn-sm" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>
    <h6>UNITED RURAL CREDIT CO-OP SOCIETY LTD.</h6>
</div>

<script>
function toggleSidebar(){
    document.querySelector('.sidebar').classList.toggle('show');
}
</script>