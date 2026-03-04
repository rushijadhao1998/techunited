<?php
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ===== SIDEBAR ===== */
.sidebar{
    position:fixed;
    top:60px;
    left:0;
    height:100%;
    width:240px;
    background:#111827;
    color:white;
    transition:0.3s;
    overflow-y:auto;
}

.sidebar a{
    color:#cbd5e1;
    display:block;
    padding:12px 20px;
    text-decoration:none;
    font-size:15px;
}
.sidebar a:hover{
    background:#1f2937;
    color:#fff;
}

/* ===== CONTENT ===== */
.content{
    margin-left:240px;
    padding:20px;
    margin-top:10px;
    transition:0.3s;
}

/* ===== COLLAPSE MODE ===== */
.sidebar-collapsed .sidebar{
    width:70px;
}
.sidebar-collapsed .content{
    margin-left:70px;
}
.sidebar-collapsed .sidebar a span{
    display:none;
}

/* ===== MOBILE ===== */
@media(max-width:768px){
    .sidebar{
        left:-240px;
    }
    .sidebar.show{
        left:0;
    }
    .content{
        margin-left:0;
    }
}

/* CARDS */
.card{
    border:none;
    border-radius:16px;
}

/* PAGE BASE */
body{
    background:#f4f6f9;
    overflow-x:hidden;
}

/* ===== TOP NAVBAR ===== */
.topbar{
    position:fixed;
    top:0;
    left:0;
    right:0;
    height:60px;
    z-index:1000;
}

/* ===== SIDEBAR ===== */
.sidebar{
    position:fixed;
    top:60px; /* below navbar */
    left:0;
    height:calc(100vh - 60px);
    width:240px;
    background:#111827;
    color:white;
    transition:0.3s;
    overflow-y:auto;
    z-index: 500;
}

/* ===== CONTENT ===== */
.content{
    margin-left:240px;
    margin-top:60px;
    padding:20px;
    transition:0.3s;
}


/* MOBILE */
@media(max-width:768px){
    .sidebar{
        left:-240px;
    }
    .sidebar.show{
        left:0;
    }
    .content{
        margin-left:0;
    }
}

.sidebar span{
    transition:opacity .2s;
}
.sidebar-collapsed .sidebar span{
    opacity:0;
}
.sidebar-collapsed .sidebar h5{
    display:none;
}

/* LOGO SIZE */
#top-logo{
    height:34px;
}

/* SMALL DEVICES */
@media(max-width:768px){

    #society-name{
        font-size:14px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        max-width:150px;
        display:inline-block;
    }

    #top-logo{
        height:28px;
    }

}

#menu-toggle2{
    display: none;
}


@media(max-width:770px){

    #menu-toggle2{
    display: block;
}

   #menu-toggle{
    display: none;
}


}



/* VERY SMALL MOBILE */
@media(max-width:480px){

    #society-name{
        display:none; /* hide long name */
    }

}


</style>
</head>

<body>

<!-- TOP NAVBAR -->
<nav class="navbar navbar-dark bg-dark topbar fixed-top px-3">

    <!-- LEFT SIDE -->
    <div class="d-flex align-items-center">

        <!-- Sidebar Toggle -->
        <button class="btn btn-outline-light me-2" id="menu-toggle2">
            <i class="bi bi-list"></i>
        </button>

        <!-- Logo -->
        <img src="../assets/images/logo.png" class="me-2" id="top-logo">

        <!-- Society Name -->
        <span class="navbar-brand mb-0 fw-bold" id="society-name">
            UNITED TECH CREDIT CO-OPERATIVE SOCIETY
        </span>
    </div>

    <!-- RIGHT SIDE -->
    <div class="d-flex align-items-center text-white">

        <span class="me-3 d-none d-md-inline">Welcome, <b>Admin</b></span>

        <a href="logout.php" class="btn btn-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i>
            <span class="d-none d-md-inline"> Logout</span>
        </a>

    </div>

</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const toggleBtn = document.getElementById("menu-toggle");

    if(toggleBtn){
        toggleBtn.addEventListener("click", function () {

            if (window.innerWidth < 768) {
                document.querySelector(".sidebar").classList.toggle("show");
            } else {
                document.body.classList.toggle("sidebar-collapsed");
            }

        });
    }

});


document.addEventListener("DOMContentLoaded", function () {

    const toggleBtn = document.getElementById("menu-toggle2");

    if(toggleBtn){
        toggleBtn.addEventListener("click", function () {

            if (window.innerWidth < 768) {
                document.querySelector(".sidebar").classList.toggle("show");
            } else {
                document.body.classList.toggle("sidebar-collapsed");
            }

        });
    }

});
</script>