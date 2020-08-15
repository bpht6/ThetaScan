<?php

$date = new Datetime("now");
$now = $date->format("U");
$week = $now - (86400*7);

$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database2 = $config['database2'];
        $password = $config['password'];

echo'
<html>
<head>
<title>ThetaScan.io - Staking Addresses</title>
<style>

a.a {
        font-family: Georgia, Times, Times New Roman, serif;
        font-size: 2.1em;
        color:#005eff;
        float: left;
        display: block;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
}
a.b {

        font-family: Georgia, Times, Times New Roman, serif;
}
body {
        background-color: #ebebeb;
        font-family: Gill Sans, Gill Sans MT, Calibri, sans-serif; 
}
div.a {

        background-color: #ffffff;
        width: 1200px;
        display: inline-block;
}
div.b {
        float: left;  
        font-size: 20px;
        display: block;
        padding: 10px 5px;
}
div.d {
        background-color: #ffffff;
        width: 1200px;
        display: inline-block;
}
a:link {
  text-decoration: none;
  color: black;
}

a:visited {
  text-decoration: none;
  color: black;
}

a:hover {
  text-decoration: none;
  color: black;
}

a:active {
  text-decoration: none;
  color: black;
}
.menu a.b {
        float: left;
        display: block;
        color: black;
        text-align: center;
        padding: 26px 16px;
        text-decoration: none;
        font-size: 20px;
}
.menu a.c {
        float: left;
        display: block;
}
.menu {
        overflow: hidden;
        background-color: #ebebeb;
        width: 1200px;
}
.menu .search{
        float: right;
}
.menu input[type=text] {
        padding: 6px;
        margin-top: 20px;
        font-size: 17px;
        border: none;
}
.menu .search button {
        float: right;
        padding: 6px 10px;
        margin-top: 20px;
        margin-right: 16px;
        background-color: #005eff;
        color: #ffffff;
        font-size: 17px;
        border: none;
        cursor: pointer;
}
select{
 float: right;
        padding: 6px 10px;
        margin-top: 4px;
        margin-right: 0px;
        background-color: #005eff;
        color: #ffffff;
        font-size: 17px;
        border: none;
}

.loader {
  border: 40px solid #FFFFFF;
  border-radius: 50%;
  border-top: 40px solid #005eff;
  width: 200px;
  height: 200px;
  -webkit-animation: spin 1s linear infinite; /* Safari */
  animation: spin 1s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
</head>
<body>
<center>
<div class="menu">
	<a class="c"> <img src="/theta.jpg"> </a>
	<a class="a" href="/" style="color:#005eff;"> ThetaScan.io</a>
	<a class="b" href="/blocks.php">Blocks</a>
	<a class="b" href="/staking.php">Staking Addresses</a>
	<div class="search">
		<form action="/address.php">
                	<input type="text" placeholder="Enter Address / Transaction Hash" name="address" size="35">
                	<button type="submit">Search</button>
          	</form>
  	</div>
  	<div>
	     	<form action="/network.php">
  			<select name = "network"onchange="this.form.submit()">
  				<option value="main_net">Main Net</option>
  				<option value="test_net">Test Net</option>
			</select>
     		</form>
  	</div>
</div>
<br>
<div id="loading" class="loader"></div><div id="loading2"> Loading - Staking Data </div>';
ob_flush();
flush();
$con=mysqli_connect($host,$user,$password,$database2);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$result = mysqli_query($con, "SELECT * FROM staking_wallets ORDER BY theta ASC") ;
{  
	while($row = mysqli_fetch_array($result)) {
		if ($row['status']=="active"){
			$staking[$row['address']]= $row['theta'];
		}
		if ($row['status']=="inactive"){
			$inactive[$row['address']]= $row['theta'];
		}
		if ($row['status']=="withdraw"){
			$withdraw[$row['address']][1]= $row['theta'];
			$withdraw[$row['address']][2]= $row['timestamp'];
			$withdrawing_theta[$row['address']] = $row['theta'];
			
		}
	}
}


arsort($staking);
arsort($inactive);
arsort($withdraw);

foreach ($staking as $wallet_add => $theta_value) {
	$active_theta = $active_theta + $theta_value;
}
foreach ($inactive as $wallet_add => $theta_value2) {
	$inactive_theta = $inactive_theta + $theta_value2;
}
foreach ($withdrawing_theta as $wallet_add => $theta_value3) {
	$withdraw_theta = $withdraw_theta + $theta_value3;
}

echo'
<div class="a">
	<div class="b" style="width: 400px;"> <a style="float:left;"> Staking Addresses </a></div>
	<br><br><hr>
	<div style="width: 400px; float:left; padding: 10px 5px;"><a style="float:left;"> Actively Staking Theta</a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.number_format($active_theta,0).'</b></a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.number_format($active_theta/10000000,2).'%</b></a></div><br><br><hr>
	<div style="width: 400px; float:left; padding: 10px 5px;"><a style="float:left;"> Inactive Staked Theta (Node Offline)</a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.number_format($inactive_theta,0).'</b></a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.number_format($inactive_theta/10000000,2).'%</b></a></div><br><br><hr>
	<div style="width: 400px; float:left; padding: 10px 5px;"><a style="float:left;"> Theta Withdrawn over the last 7 days from a node</a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.number_format($withdraw_theta,0).'</b></a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.number_format($withdraw_theta/10000000,2).'%</b></a></div>
	<br><br><hr>
</div><br><br>
<div class="d" id="active">
 	<div class="b"> <a style="float:left; color:#005eff;" href="#" onclick="active()"> Active Staking Addresses </a> &nbsp; &nbsp; | &nbsp; &nbsp; </div>
 	<div class="b"> <a style="float:left;" href="#" onclick="inactive()"> Inactive Addresses </a> &nbsp; &nbsp; | &nbsp; &nbsp; </div>
 	<div class="b"> <a style="float:left;" href="#" onclick="withdraw()"> Withdrawing Addresses (Last 7 Days) </a></div>
 	<br><br><br><br>
	<div style="width: 100px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
	<div style="width: 500px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Address </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Amount</a></div>
	<div style="width: 160px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Status </a></div>
	<br><br>';
$num = 1;
foreach ($staking as $wallet_add => $theta_value) {

	echo'
	<div style="width: 100px; float:left; padding: 10px 5px;"><a> '.$num.'  </a></div>
	<div style="width: 500px; float:left; padding: 10px 5px;"><a style="float:left;" href="/staking_address.php?address='.$wallet_add.'">  '.$wallet_add.' </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format($theta_value,2).' </a></div>
	<div style="width: 160px; float:left; padding: 10px 5px;"><a style="float:left;"> Theta </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px;"><a style="float:left;"> Active </a></div>
	<br><br><hr>';
	$num++;
}
echo'
</div>';

echo'
<div class="d" id="inactive" style="display:none;">
	<div class="b"> <a style="float:left;" href="#" onclick="active()"> Active Staking Addresses </a> &nbsp; &nbsp; | &nbsp; &nbsp; </div>
	<div class="b"> <a style="float:left; color:#005eff;" href="#" onclick="inactive()"> Inactive Addresses </a> &nbsp; &nbsp; | &nbsp; &nbsp; </div>
	<div class="b"> <a style="float:left;" href="#" onclick="withdraw()"> Withdrawing Addresses (Last 7 Days) </a></div>
	<br><br><br><br>
	<div style="width: 100px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
	<div style="width: 500px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Address </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Amount</a></div>
	<div style="width: 160px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Status </a></div>
	<br><br>';
$num = 1;
foreach ($inactive as $wallet_add => $theta_value) {

	echo'
	<div style="width: 100px; float:left; padding: 10px 5px;"><a> '.$num.'  </a></div>
	<div style="width: 500px; float:left; padding: 10px 5px;"><a style="float:left;" href="/staking_address.php?address='.$wallet_add.'">  '.$wallet_add.' </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format($theta_value,2).' </a></div>
	<div style="width: 160px; float:left; padding: 10px 5px;"><a style="float:left;"> Theta </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px;"><a style="float:left;"> Offline </a></div>
	<br><br><hr>';
	$num++;
}
echo'
</div>
<div class="d" id="withdraw" style="display:none;">
	<div class="b"> <a style="float:left;" href="#" onclick="active()"> Active Staking Addresses </a> &nbsp; &nbsp; | &nbsp; &nbsp; </div>
	<div class="b"> <a style="float:left;" href="#" onclick="inactive()"> Inactive Addresses </a> &nbsp; &nbsp; | &nbsp; &nbsp; </div>
	<div class="b"> <a style="float:left; color:#005eff;" href="#" onclick="withdraw()"> Withdrawing Addresses (Last 7 Days) </a></div>
	<br><br><br><br>
	<div style="width: 100px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
	<div style="width: 500px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Address </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Amount</a></div>
	<div style="width: 160px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Age </a></div>
	<br><br>';
$num = 1;
foreach ($withdraw as $wallet_add => $theta_value) {
	$age = $now - $withdraw[$wallet_add][2];
	if ($age < 60){$age_details = "Secs"; $new_age = $age;} 
	else if ($age < 3600){$age_details = "Mins"; $new_age = $age / 60;}
	else if ($age < 86400){$age_details = "Hours"; $new_age = $age / 3600;}
	else if ($age < 31536000){$age_details = "Days"; $new_age = $age / 86400;}
	else {$age_details = "Years"; $new_age = $age / 31536000;}
	echo'
	<div style="width: 100px; float:left; padding: 10px 5px;"><a> '.$num.'  </a></div>
	<div style="width: 500px; float:left; padding: 10px 5px;"><a style="float:left;" href="/staking_address.php?address='.$wallet_add.'">  '.$wallet_add.' </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format($withdraw[$wallet_add][1],2).' </a></div>
	<div style="width: 160px; float:left; padding: 10px 5px;"><a style="float:left;"> Theta </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format($new_age,0).' '.$age_details.' </a></div>
	<br><br><hr>';
	$num++;
}
echo'
</div>
<br><br><br>
<div style="width:1200px;">
	<div style="float:left;"><a href="/broadcast_txn.php"> Broadcast TXN</a></div>
	<div style="float:center;"><a href="/status.php"> Node Status</a></div>
</div>
<br><br>
</center>
</body>
</html>

<script>
function inactive() {
	var act = document.getElementById("active");
	var ina = document.getElementById("inactive");
	var wit = document.getElementById("withdraw");
	act.style.display = "none";
	ina.style.display = "block";
	wit.style.display = "none";
} 
function active() {
	var act = document.getElementById("active");
	var ina = document.getElementById("inactive");
	var wit = document.getElementById("withdraw");
	act.style.display = "block";
	ina.style.display = "none";
	wit.style.display = "none";
} 
function withdraw() {
	var act = document.getElementById("active");
	var ina = document.getElementById("inactive");
	var wit = document.getElementById("withdraw");
	act.style.display = "none";
	ina.style.display = "none";
	wit.style.display = "block";
} 
document.getElementById("loading").style.display = "none";
document.getElementById("loading2").style.display = "none";
</script>';
?>
