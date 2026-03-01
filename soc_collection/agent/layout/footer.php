</div>

<!-- Bottom Mobile Nav -->
<div class="bottom-nav">
    <a href="dashboard.php">
        <i class="bi bi-house"></i>
        <span>Home</span>
    </a>

    <a href="customers.php">
        <i class="bi bi-people"></i>
        <span>Customers</span>
    </a>

    <a href="transaction.php" class="center-btn">
        <i class="bi bi-plus-lg"></i>
    </a>

    <a href="agent-statement.php">
        <i class="bi bi-file-text"></i>
        <span>Reports</span>
    </a>

    <a href="profile.php">
        <i class="bi bi-person"></i>
        <span>Profile</span>
    </a>
</div>

<div class="footer-text">
Copyright © <?= date('Y') ?>, <a href="https://unitedtech.in/">United Technologies Pvt Ltd</a>
</div>

<style>

   .footer-text a {
            text-decoration: none;
            font-size: 12px;
    color: #888;
        }
.bottom-nav{
    position:fixed;
    bottom:0;
    left:0;
    width:100%;
    height:65px;
    background:#fff;
    border-top:1px solid #ddd;
    display:flex;
    justify-content:space-around;
    align-items:center;
    z-index:999;
}

.bottom-nav a{
    text-decoration:none;
    color:#6c757d;
    font-size:12px;
    text-align:center;
}

.bottom-nav i{
    display:block;
    font-size:20px;
}

.center-btn{
    background:#0d6efd;
    color:#fff!important;
    width:55px;
    height:55px;
    border-radius:50%;
    display:flex!important;
    justify-content:center;
    align-items:center;
    margin-top:-25px;
    box-shadow:0 4px 12px rgba(0,0,0,.25);
}

.footer-text{
    text-align: center;
    font-size: 11px;
    color: #888;
    margin-bottom: 70px;
}
</style>


<script>
(function(){

    let workingDate = new Date().toDateString();

    setInterval(function(){

        let now = new Date().toDateString();

        if(now !== workingDate){
            document.getElementById("dayChangeModal").style.display="flex";
        }

    },30000);

})();

function reloadPage(){
    location.reload();
}
</script>


<!-- Midnight Change Modal -->
<div id="dayChangeModal" class="day-modal">
  <div class="day-box">
      <div class="icon">🌙</div>
      <h5>New Collection Day Started</h5>
      <p>Your working date has changed.<br>Reload to continue collections.</p>
      <button onclick="reloadPage()">Continue</button>
  </div>
</div>

<style>
.day-modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:2000;
}

.day-box{
    background:#fff;
    width:90%;
    max-width:320px;
    border-radius:18px;
    padding:22px;
    text-align:center;
    animation:pop .25s ease;
}

.day-box .icon{
    font-size:40px;
    margin-bottom:10px;
}

.day-box h5{
    font-weight:600;
    margin-bottom:5px;
}

.day-box p{
    font-size:14px;
    color:#555;
}

.day-box button{
    margin-top:12px;
    background:#0d6efd;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    width:100%;
    font-weight:600;
}

@keyframes pop{
    from{transform:scale(.8);opacity:.3}
    to{transform:scale(1);opacity:1}
}
</style>

</body>
</html>