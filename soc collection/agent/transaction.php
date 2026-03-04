<?php
session_start();
include "../config/db.php";
include "layout/header.php";
include "layout/sidebar.php";

$first_ledger = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT id FROM gl_master WHERE status='active' ORDER BY id LIMIT 1
"))['id'] ?? '';

$date = date('Y-m-d');
$ledgers = mysqli_query($conn,"SELECT id,ledger_name FROM gl_master WHERE status='active'");
?>

<style>
.box{background:#fff;padding:16px;border-radius:18px;box-shadow:0 4px 12px rgba(0,0,0,.07);margin-bottom:15px;}
</style>

<div class="container">

<h5 class="mb-3">Collection</h5>

<div class="box">

<label>General Ledger</label>
<select id="ledger" class="form-select mb-3">
<?php while($l=mysqli_fetch_assoc($ledgers)){ ?>
<option value="<?=$l['id']?>" <?=$l['id']==$first_ledger?'selected':''?>>
<?=$l['ledger_name']?>
</option>
<?php } ?>
</select>

<label>Transaction Date</label>
<input type="date" id="tdate" class="form-control mb-3" value="<?=$date?>">

<label>Search Customer</label>
<input type="text" id="search" class="form-control" placeholder="Type name or account no">

<div id="result" class="list-group mt-2"></div>

</div>

</div>

<script>
document.getElementById("search").addEventListener("keyup",function(){

let ledger=document.getElementById("ledger").value;
let date=document.getElementById("tdate").value;
let q=this.value;

if(ledger==""||q.length<2) return;

fetch(`search-account.php?q=${q}&ledger=${ledger}&date=${date}`)
.then(res=>res.text())
.then(data=>document.getElementById("result").innerHTML=data);
});
</script>

<?php include "layout/footer.php"; ?>