<?php
header( 'Content-type: text/html; charset=utf-8' );
$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database = $config['database'];
        $database2 = $config['database2'];
        $password = $config['password'];
        
$con=mysqli_connect($host,$user,$password,$database);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$con1=mysqli_connect($host,$user,$password,$database2);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT * FROM prices ");
{  
	while($row = mysqli_fetch_array($result)) {
		if ($row["name"]=="THETA") {
			$theta_price = $row["price"];
			$theta_change = $row["percent_change"];
			$theta_volume = $row["volume"];
			$theta_market = $row["market"];
		}
		if ($row["name"]=="TFUEL") {
			$tfuel_price = $row["price"];
			$tfuel_change = $row["percent_change"];
			$tfuel_volume = $row["volume"];
			$tfuel_market = $row["market"];
		}
	}
}
echo'
<html>
<head>
<title>ThetaScan.io</title>
<style>
.alert {
  padding: 20px;
  font-size: 20px;
  background-color: #ffcc00;
  width: 1200;
}
.alertbtn {
  margin-left: 15px;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}
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
        font-family: Georgia, Times, Times New Roman, serif;
        width: 600px;
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
  -webkit-animation: spin 1.5s linear infinite; /* Safari */
  animation: spin 1.5s linear infinite;
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
	<a class="c"> <img src="theta.jpg"> </a>
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

<div class="a">
	<div style="width: 60px; float:left; padding: 15px 5px;"> <img src="theta_small.jpg" /></div> 
	<div style="width: 120px; float:left; padding: 25px 5px;"> <a style="float:left;"> Price </a> </div>
	<div style="width: 100px; float:left; padding: 25px 5px;"> <a style="float:left;"><b> $'.number_format($theta_price,4).'</b> </a> </div>
	<div style="width: 120px; float:left; padding: 25px 5px;"> <a style="float:left;"> Volume (24H) </a> </div>
	<div style="width: 150px; float:left; padding: 25px 5px;"> <a style="float:left;"><b> $'.number_format($theta_volume,0).'</b> </a> </div>
	<div style="width: 120px; float:left; padding: 25px 5px;"> <a style="float:left;"> Change (24H) </a> </div>
	<div style="width: 100px; float:left; padding: 25px 5px;"> <a style="float:left;"><b> '.number_format($theta_change,2).'%</b> </a> </div>
	<div style="width: 120px; float:left; padding: 25px 5px;"> <a style="float:left;"> Market Cap </a> </div>
	<div style="width: 150px; float:left; padding: 25px 5px;"> <a style="float:left;"><b> $'.number_format($theta_market,0).'</b> </a> </div>
</div>

<div class="a">
	<div style="width: 60px; float:left; padding: 15px 5px;"> <img src="tfuel_small.jpg" /></div>
	<div style="width: 120px; float:left; padding: 25px 5px;"> <a style="float:left;"> Price </a> </div>
	<div style="width: 100px; float:left; padding: 25px 5px;"> <a style="float:left;"><b> $'.number_format($tfuel_price,4).'</b> </a> </div>
	<div style="width: 120px; float:left; padding: 25px 5px;"> <a style="float:left;"> Volume (24H) </a> </div>
	<div style="width: 150px; float:left; padding: 25px 5px;"> <a style="float:left;"><b> $'.number_format($tfuel_volume,0).'</b> </a> </div>
	<div style="width: 120px; float:left; padding: 25px 5px;"> <a style="float:left;"> Change (24H) </a> </div>
	<div style="width: 100px; float:left; padding: 25px 5px;"> <a style="float:left;"><b> '.number_format($tfuel_change,2).'%</b> </a> </div>
	<div style="width: 120px; float:left; padding: 25px 5px;"> <a style="float:left;"> Market Cap </a> </div>
	<div style="width: 150px; float:left; padding: 25px 5px;"> <a style="float:left;"><b> $'.number_format($tfuel_market,0).'</b> </a> </div>
</div>
<br><br><br>
<div id="loading" class="loader"></div><div id="loading2"> Loading - Recent Transactions </div>';
ob_flush();
flush();
echo'
<div class="d">
	<div class="b"> <a style="float:left;"> Recent Send Transactions </a></div>
	<br><br><br>
	<div style="width: 200px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Block </a></div>
	<div style="width: 700px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Hash </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a style="float:left;"> Amount </a></div>
	<div style="width: 60px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
	<br><br>';

$result = mysqli_query($con1, "SELECT block,type,hash,sent_thetawei,sent_tfuelwei FROM transactions ORDER BY block DESC LIMIT 10");
{  
	while($row = mysqli_fetch_array($result)) {
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a  href="/block_details.php?height='.$row["block"].'"> '.$row["block"].'</a></div>
		<div style="width: 700px; float:left; padding: 10px 5px;"><a style="float:left;" href="/hash.php?hash='.$row["hash"].'"> '.$row["hash"].' </a></div>';
		if ($row["sent_thetawei"] > 0){
			echo'<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format($row["sent_thetawei"]/1000000000000000000,2).'</a></div>
			<div style="width: 60px; float:left; padding: 10px 5px;"><a style="float:left;"> Theta </a></div>';
		}else{
			echo'<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format($row["sent_tfuelwei"]/1000000000000000000,2).'</a></div>
			<div style="width: 60px; float:left; padding: 10px 5px;"><a style="float:left;" > TFuel </a></div>';
		}
		echo'<br><br><hr>';
	}
}


echo'</div>
<br><br><br>
<div style="width:1200px;">
	<div style="float:left;"><a href="/broadcast_txn.php"> Broadcast TXN</a></div>
	<div style="float:center;"><a href="/status.php"> Node Status</a></div>
</div>
<br><br>
</center>
</html>
<script>
function hide() {
	var message = document.getElementById("message");
	message.style.display = "none";
} 
document.getElementById("loading").style.display = "none";
document.getElementById("loading2").style.display = "none";
</script>
';

?>
