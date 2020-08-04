<?php
$address = $_GET["hash"];

if (preg_match('/^(0x)?[0-9a-f]{64}$/i', $address) == 0) {
	echo '<script type="text/javascript">
        window.location = "/error.php?address='.$address.'"
        </script>';
}

$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database = $config['database'];
        $password = $config['password'];
        $network = $config['mainnet'];
        
$con=mysqli_connect($host,$user,$password,$database);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result8 = mysqli_query($con, "SELECT * FROM prices ");{  
	while($row = mysqli_fetch_array($result8)) {
		if ($row["name"]=="THETA") {$theta_price = $row["price"];}
		if ($row["name"]=="TFUEL") {$tfuel_price = $row["price"];}
	}
}

$url = 'http://localhost/rpc';
$data = array("jsonrpc" => "2.0","method" => "theta.GetTransaction","params"=>[array("hash"=>"$address")],"id"=>"1");
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
$status= $details['result']['status'];
$type = $details['result']['type'];
$block_height = $details['result']['block_height'];

if ($type == 0) {$type_name = "Coinbase" ;}
if ($type == 1) {$type_name = "Slash";}
if ($type == 2) {$type_name = "Send";}
if ($type == 3) {$type_name = "Reserve Fund";}
if ($type == 4) {$type_name = "Release Fund";}
if ($type == 5) {$type_name = "Service Payment";}
if ($type == 6) {$type_name = "Split Rule";}
if ($type == 7) {$type_name = "Smart Contract";}
if ($type == 9) {$type_name = "Withdraw Stake";}
if ($type == 10) {$type_name = "Deposit Stake";}


echo'
<html>
<head>
<title>ThetaScan.io - Hash Details</title>
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
        float: left;  
        font-size: 12px;
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

</style>
</head>
<body>

<center>
<div class="menu">
  <a class="c"> <img src="/theta.jpg"> </a>
  <a class="a" href="/" style="color:#005eff;"> ThetaScan</a>
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

<br><br><br>

<div class="d">
	<div class="b"> <a style="float:left;"> Hash Details </a></div>
	<div style="float:right; padding: 10px 5px;"><a style="float:right;"> <a style="floatright;" target="_blank" href="/download_txn.php?hash='.$address.'"> Export Raw Transaction </div>
	<div style="float:right; padding: 10px 5px;"><img src="/download.jpg" width="25" height="25"> </a></div>
	<br><br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Hash </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$address.' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Status </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left; text-transform:capitalize;"> '.$status.' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Type </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$type.' - '.$type_name.'</a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Block </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/block_details.php?height='.$block_height.'"> '.$block_height.' </a></div>';

if ($type == 0) {
	echo '</div><br><br>';
	$output_count = count($details['result']['transaction']['outputs']);
	for ($z = 0; $z <= $output_count-1; $z++) {
		$amt_tfuel = number_format($details['result']['transaction']['outputs'][$z]['coins']['tfuelwei']/1000000000000000000,6);
		$amt_theta = number_format($details['result']['transaction']['outputs'][$z]['coins']['thetawei']/1000000000000000000,4); 
		echo'
		<br><br><br>
		<div class="d">
			<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> To Address </a></div>
			<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/address.php?address='.$details['result']['transaction']['outputs'][$z]['address'].'"> '.$details['result']['transaction']['outputs'][$z]['address'].'</a></div>
			<br><br><hr>';
		if ($amt_theta <> 0){
			echo'<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
			<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_theta.' Theta</a></div>
			<br><br><hr>';
		}
		if ($amt_tfuel <> 0){
			echo'<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
			<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_tfuel.' TFuel</a></div>
			<br><br><hr>';
		}
		echo'</div>';
	}
} else if ($type == 2) {
	echo '<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> From Address </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/address.php?address='.$details['result']['transaction']['inputs'][0]['address'].'"> '.$details['result']['transaction']['inputs'][0]['address'].'</a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Fee </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" > '.number_format($details['result']['transaction']['fee']['tfuelwei']/1000000000000000000,6).' TFuel</a></div>
	</div>'; 
	$output_count = count($details['result']['transaction']['outputs']);
	for ($z = 0; $z <= $output_count-1; $z++) {
		$amt_tfuel = number_format($details['result']['transaction']['outputs'][$z]['coins']['tfuelwei']/1000000000000000000,6);
		$amt_theta = number_format($details['result']['transaction']['outputs'][$z]['coins']['thetawei']/1000000000000000000,4); 
		echo'<br><br><br>
		<div class="d">
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> To Address </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/address.php?address='.$details['result']['transaction']['outputs'][$z]['address'].'"> '.$details['result']['transaction']['outputs'][$z]['address'].'</a></div>
		<br><br><hr>';
		if ($amt_theta <> 0){
			echo'
			<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
			<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_theta.' Theta</a></div>
			<br><br><hr>';
		}
		if ($amt_tfuel <> 0){
			echo'
			<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
			<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_tfuel.' TFuel</a></div>
			<br><br><hr>';
		}
		echo'</div>';
	}
} else if ($type == 3) {
	echo '</div><br><br>';
	$col_tfuel = number_format($details['result']['transaction']['collateral']['tfuelwei']/1000000000000000000,6);
	$col_theta = number_format($details['result']['transaction']['collateral']['thetawei']/1000000000000000000,4);
	$amt_tfuel = number_format($details['result']['transaction']['source']['coins']['tfuelwei']/1000000000000000000,6);
	$amt_theta = number_format($details['result']['transaction']['source']['coins']['thetawei']/1000000000000000000,4);

	echo '
	</div><br><br><br>
	<div class="d">
	<div class="b"> <a style="float:left;"> Details </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Fee </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.number_format($details['result']['transaction']['fee']['tfuelwei']/1000000000000000000,6).' TFuel</a></div>
	<br><br><hr>';
	if ($col_theta <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Collateral </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$col_theta.' Theta</a></div>
		<br><br><hr>';
	}
	if ($col_tfuel <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Collateral </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$col_tfuel.' TFuel </a></div>
		<br><br><hr>';
	}
	echo'
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Duration </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$details['result']['transaction']['duration'].' </a></div>
	<br><br><hr>';
	if ($amt_theta <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_theta.' Theta</a></div>
		<br><br><hr>';
	}
	if ($amt_tfuel <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_tfuel.' TFuel</a></div>
		<br><br><hr>';
	}
	echo'
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Source Address </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/address.php?address='.$details['result']['transaction']['source']['address'].'" /> '.$details['result']['transaction']['source']['address'].' </a></div>
	<br><br><hr>';
	$output_count = count($details['result']['transaction']['resource_ids']);
	for ($z = 0; $z <= $output_count-1; $z++) {
		echo' 
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Resource ID </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$details['result']['transaction']['resource_ids'][$z].' </a></div>
		<br><br><hr>';
	}
	echo'</div>';
} else if ($type == 5) {
	echo '</div><br><br>';
	$amt_tfuel = number_format($details['result']['transaction']['source']['coins']['tfuelwei']/1000000000000000000,6);
	$amt_theta = number_format($details['result']['transaction']['source']['coins']['thetawei']/1000000000000000000,4);

	echo '
	</div><br><br><br>
	<div class="d">
	<div class="b"> <a style="float:left;"> Details </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Fee </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.number_format($details['result']['transaction']['fee']['tfuelwei']/1000000000000000000,6).' TFuel</a></div>
	<br><br><hr>';
	if ($amt_theta <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_theta.' Theta</a></div>
		<br><br><hr>';
	}
	if ($amt_tfuel <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_tfuel.' TFuel</a></div>
		<br><br><hr>';
	}
	echo'
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> From Address </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/address.php?address='.$details['result']['transaction']['source']['address'].'" /> '.$details['result']['transaction']['source']['address'].' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> To Address </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/address.php?address='.$details['result']['transaction']['target']['address'].'" /> '.$details['result']['transaction']['target']['address'].' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Payment Sequence </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$details['result']['transaction']['payment_sequence'].' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Reserve Sequence </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$details['result']['transaction']['reserve_sequence'].' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Resource ID </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$details['result']['transaction']['resource_id'].' </a></div>
	<br><br><hr>
	</div>';
} else if ($type == 9) {
	echo '</div><br><br>';
	$amt_tfuel = number_format($details['result']['transaction']['source']['coins']['tfuelwei']/1000000000000000000,6);
	$amt_theta = number_format($details['result']['transaction']['source']['coins']['thetawei']/1000000000000000000,4);
	echo '
	</div><br><br><br>
	<div class="d">
	<div class="b"> <a style="float:left;"> Details </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Fee </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.number_format($details['result']['transaction']['fee']['tfuelwei']/1000000000000000000,6).' TFuel</a></div>
	<br><br><hr>';
	if ($amt_theta <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_theta.' Theta</a></div>
		<br><br><hr>';
	}
	if ($amt_tfuel <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_tfuel.' TFuel</a></div>
		<br><br><hr>';
	}
	echo'
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> From Address </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/address.php?address='.$details['result']['transaction']['source']['address'].'" /> '.$details['result']['transaction']['source']['address'].' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Node Address </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$details['result']['transaction']['holder']['address'].' </a></div>
	<br><br><hr>
	</div>';
} else if ($type == 10) {
	echo '</div><br><br>';
	$amt_tfuel = number_format($details['result']['transaction']['source']['coins']['tfuelwei']/1000000000000000000,6);
	$amt_theta = number_format($details['result']['transaction']['source']['coins']['thetawei']/1000000000000000000,4);
	echo '
	</div><br><br><br>
	<div class="d">
	<div class="b"> <a style="float:left;"> Details </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Fee </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.number_format($details['result']['transaction']['fee']['tfuelwei']/1000000000000000000,6).' TFuel</a></div>
	<br><br><hr>';
	if ($amt_theta <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_theta.' Theta</a></div>
		<br><br><hr>';
	}
	if ($amt_tfuel <> 0){
		echo'
		<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Amount </a></div>
		<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$amt_tfuel.' TFuel</a></div>
		<br><br><hr>';
	}
	echo'
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> From Address </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;" href="/address.php?address='.$details['result']['transaction']['source']['address'].'" /> '.$details['result']['transaction']['source']['address'].' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Node Address </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px; "><a style="float:left;"> '.$details['result']['transaction']['holder']['address'].' </a></div>
	<br><br><hr>
	</div>';
} else {
        echo '</div><br><br><br>
	<div class="d">
	<div class="b"> <a style="float:left;"> Details </a></div>
	<br><br><hr>';
	$raw_transaction = json_encode($details['result']['transaction']);
	echo'
        <div style="width: 1190px; float:left; padding: 10px 5px;"><a style="float:left;"> Transaction is not mapped. Displaying raw transaction. </a></div>
	<br><br><hr>
        <div style="width: 1190px; float:left; padding: 10px 5px;"><a style="float:none; width:1190px; word-wrap: break-word;">'.$raw_transaction.'  </a></div>
	<br><br><hr>
	</div>';
}


echo'
<br><br><br>
<div style="width:1200px;">
	<div style="float:left;"><a href="/broadcast_txn.php"> Broadcast TXN</a></div>
	<div style="float:center;"><a href="/status.php"> Node Status</a></div>
</div>
<br><br>
</center>
</body>
</html>';

?>