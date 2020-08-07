<?php
header( 'Content-type: text/html; charset=utf-8' );
date_default_timezone_set('UTC');
$address = $_GET["address"];
$transaction_start = $_GET["index"];
if ($transaction_start == ""){$transaction_start=0;}
$back = $transaction_start - 10;
$next = $transaction_start + 10;
$start = $transaction_start +1;

if (preg_match('/^(0x)?[0-9a-f]{40}$/i', $address) == 0) {
	echo '<script type="text/javascript">

        window.location = "/hash.php?hash='.$address.'"

        </script>';
}
$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database = $config['database'];
        $database2 = $config['database2'];
        $password = $config['password'];
        $network = $config['mainnet'];
        
        
$con=mysqli_connect($host,$user,$password,$database);

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result8 = mysqli_query($con, "SELECT * FROM prices ");
{  

	while($row = mysqli_fetch_array($result8)) {
		if ($row["name"]=="THETA") {$theta_price = $row["price"];}
		if ($row["name"]=="TFUEL") {$tfuel_price = $row["price"];}
	}
}

$con1=mysqli_connect($host,$user,$password,$database2);
if (mysqli_connect_errno()) {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$url = 'http://localhost/rpc';
$data = array("jsonrpc" => "2.0","method" => "theta.GetAccount","params"=>[array("address"=>"$address")],"id"=>"1");
$postdata = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_PORT, $network);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
curl_close($ch);

$details = json_decode($result, true);
$theta= $details['result']['coins']['thetawei']/1000000000000000000;
$tfuel= $details['result']['coins']['tfuelwei']/1000000000000000000;
$sequence= $details['result']['sequence'];
$theta_value = $theta * $theta_price;
$tfuel_value = $tfuel * $tfuel_price;
$online= $details['id'];

echo'
<html>
<title>ThetaScan.io - Address Search</title>
<head>
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
        width: 1200px;
        height: 210px;
        display: inline-block;
}
div.b {
        float: left;  
        font-size: 20px;
        display: block;
        padding: 10px 5px;
}

div.c {
        float: right;  
        font-size: 20px;
        display: block;
        padding: 10px 5px;
}
div.d {
        background-color: #ffffff;
        width: 1200px;
        display: inline-block;
}
div.e {
        background-color: #ffffff;
        width: 400px;
        height: 210px;
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
hr {
        height: 2px;
        background-color: #ccc;
        border: none;
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

.dropdown {
  	position: relative;
  	display: inline-block;

}

.dropdown-content {
  	display: none;
  	position: absolute;
  	background-color: #f9f9f9;
  	box-shadow: 0px 4px 4px 4px rgba(0,0,0,0.5);
  	padding: 5px 5px;

}

.dropdown:hover .dropdown-content {
	display: block;

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
</div>';
if ($online <> "1") {
echo'
	<div class="alert" id="message">
		<span class="alertbtn" onclick="hide();">&times;</span>
		<b>Alert:</b> The node is offline and will not display balances at the moment.<br>
		Do not worry your Theta and TFuel are safe and secure.<br>
	 	Check back later and the node should be back online.<br>	
</div> 
<br>';
}
echo'
<br>

<div class="a">
	<div style="width: 400px; float:left; padding: 10px 5px;"><img src="/qrcode_image.php?address='.$address.'" width="180" height="180" style="float:center" /></div>
	<div class="b" style="width: 120px;"> <a style="float:left;"> Address </a></div>
	<div class="b"><b>'.$address.'</b></div>
	<br><br><hr>
	<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;"> Theta Balance </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.number_format($theta,2).'</b></a></div>
	<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;"> TFuel Balance </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.number_format($tfuel,2).'</b></a></div>
	<br><br><hr>
	<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;"> Theta Value </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>$'.number_format($theta_value,2).'</b></a></div>
	<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;"> TFuel Value </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>$'.number_format($tfuel_value,2).'</b></a></div>
	<br><br><hr>
	<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;"> Sequence </a></div>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"><b>'.$sequence.'</b></a></div>
	<div style="float:left; padding: 10px 5px;"><a style="float:left;" href="/download_transaction.php?address='.$address.'"> Export Transactions </a></div>
	<div style="float:left; padding: 10px 5px;"><img src="/download.jpg" width="25" height="25"> </a></div>
</div>
<br><br><br>
<div id="loading" class="loader"></div><div id="loading2"> Loading - Transactions </div>';
ob_flush();
flush();
echo'

<div class="d">
	<div class="b"> <a style="float:left;"> Send Transactions</a></div>
	<div class="b"> <a> ( '.$start.' - '.$next.' )</a></div>
	<br><br><br>
	<div style="width: 210px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Hash </a></div>
	<div style="width: 120px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Block </a></div>
	<div style="width: 120px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Age </a></div>
	<div style="width: 220px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> From </a></div>
	<div style="width: 220px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> To </a></div>
	<div style="width: 120px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Value </a></div>
	<div style="width: 120px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
<br><br>';

$now = time();
$result = mysqli_query($con1, "SELECT block,type,hash,add_to,add_from,sent_thetawei,sent_tfuelwei,timestamp FROM transactions WHERE (add_to = '$address' OR add_from = '$address') ORDER BY block DESC LIMIT 10 OFFSET $transaction_start");
{  
	while($row = mysqli_fetch_array($result)) {
		$age = $now - $row['timestamp'];
		if ($age < 60){$age_details = "Secs"; $new_age = $age;} 
		else if ($age < 3600){$age_details = "Mins"; $new_age = $age / 60;}
		else if ($age < 86400){$age_details = "Hours"; $new_age = $age / 3600;}
		else if ($age < 31536000){$age_details = "Days"; $new_age = $age / 86400;}
		else {$age_details = "Years"; $new_age = $age / 31536000;}

		echo'
		<div class="dropdown" style="width: 210px; float:left; padding: 10px 5px;"><span><a href="/hash.php?hash='.$row['hash'].'"> '.substr($row['hash'],0,18).'...</a></span>
		<div class="dropdown-content">'.$row['hash'].'</div></div>
		<div style="width: 120px; float:left; padding: 10px 5px;"><a href="/block_details.php?height='.$row['block'].'"> '.$row['block'].' </a></div>
		<div style="width: 120px; float:left; padding: 10px 5px;"><a> '.number_format($new_age,0).' '.$age_details.' </a></div>
		<div class="dropdown" style="width: 220px; float:left; padding: 10px 5px;"><span><a href="/address.php?address='.$row['add_from'].'">'.substr($row['add_from'],0,18).'...</a></span>
		<div class="dropdown-content">'.$row['add_from'].'</div></div>
		<div class="dropdown"style="width: 220px; float:left; padding: 10px 5px;"><span><a href="/address.php?address='.$row['add_to'].'">'.substr($row['add_to'],0,18).'...</a></span>
		<div class="dropdown-content">'.$row['add_to'].'</div></div>';

 		if ($row["sent_thetawei"] > 0){
  			echo'<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format($row["sent_thetawei"]/1000000000000000000,2).'</a></div>
 			<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;"> Theta </a></div>';
		}else{
			echo'<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format($row["sent_tfuelwei"]/1000000000000000000,2).'</a></div>
			<div style="width: 120px; float:left; padding: 10px 5px;"><a style="float:left;" > TFuel </a></div>';
		}
		echo' <br><br><hr>';
	}
}
if ( $transaction_start <> 0) { echo'<div style="width: 220px; float:left;"><a href="/address.php?address='.$address.'&index='.$back.'"> << Back </a></div>';}
echo'<div style="width: 220px; float:right;"><a href="/address.php?address='.$address.'&index='.$next.'" > Next >> </a></div>
<br><br>
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
document.getElementById("loading").style.display = "none";
document.getElementById("loading2").style.display = "none";
</script>
';

?>
