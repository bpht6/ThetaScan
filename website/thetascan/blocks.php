<?php
date_default_timezone_set('UTC');
$index = $_GET["index"];
$max = $_GET["max"];

$config = parse_ini_file('/var/www/config.ini');
        $network = $config['mainnet'];

$url = 'http://localhost/rpc';

$data_current = array("jsonrpc" => "2.0","method" => "theta.GetStatus","params"=>[],"id"=>"1");

$postdata = json_encode($data_current);

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
$status = json_decode($result, true);
$e_block = $status["result"]["latest_finalized_block_height"];

if ($index == ""){$block_start=$e_block; $max=$e_block;}else {$block_start=$index;}
$back = $block_start + 25;
$next = $block_start - 25;
$start = $block_start +1;

echo'
<html>
<head>
<title>ThetaScan.io - Recent Blocks</title>
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

.menu a.b {

        float: left;
        display: block;
        color: black;
        text-align: center;
        padding: 26px 16px;
        text-decoration: none;
        font-size: 20px;

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

<div class="d">
	<div class="b"> <a style="float:left;"> Blocks </a></div>
	<br><br><br>
	<div style="width: 150px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Height </a></div>
	<div style="width: 630px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Hash </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Age </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> Transactions </a></div>
	<br><br>';

for ($block_num = $block_start; $block_num > $block_start-25; $block_num--) {

	$data = array("jsonrpc" => "2.0","method" => "theta.GetBlockByHeight","params"=>[array("height"=>"$block_num")],"id"=>"1");

	$postdata = json_encode($data);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_PORT, 16888);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
	curl_close($ch);

	$block = json_decode($result, true);
	$timestamp = $block["result"]["timestamp"];
	$transaction = $block["result"]["transactions"];
	$hash = $block["result"]["hash"];
	$count = count($transaction);
	$now = time();
	$age = $now - $timestamp;
	if ($age < 60){$age_details = "Secs"; $new_age = $age;} 
	else if ($age < 3600){$age_details = "Mins"; $new_age = $age / 60;}
	else if ($age < 86400){$age_details = "Hours"; $new_age = $age / 3600;}
	else if ($age < 31536000){$age_details = "Days"; $new_age = $age / 86400;}
	else {$age_details = "Years"; $new_age = $age / 31536000;}

	echo'
	<div style="width: 150px; float:left; padding: 10px 5px;"><a href="/block_details.php?height='.$block_num.'">'. $block_num .'</a></div>
	<div style="width: 630px; float:left; padding: 10px 5px;"><a href="/block_details.php?height='.$block_num.'" style="float:left;" >'. $hash .' </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px;"><a>'.number_format($new_age,0) .' '.$age_details.' </a></div>
	<div style="width: 190px; float:left; padding: 10px 5px;"><a>'. $count .'</a></div>
	<br><br><hr>';
}

if ( $block_start < $max ) {
	echo'
	<div style="width: 220px; float:left;"><a href="/blocks.php?index='.$back.'&max='.$max.'"> << Back </a></div>';
}
echo'
<div style="width: 220px; float:right;"><a href="/blocks.php?index='.$next.'&max='.$max.'" > Next >> </a></div>
<br><br>
</div>
<br><br><br>
<div style="width:1200px;">
	<div style="float:left;"><a href="/broadcast_txn.php"> Broadcast TXN</a></div>
	<div style="float:center;"><a href="/status.php"> Node Status</a></div>
</div>
<br><br>
</center>
</html>';

?>
