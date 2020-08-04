<?php

$block_num = $_GET["height"];

$config = parse_ini_file('/var/www/config.ini');
$network = $config['mainnet'];

$url = 'http://localhost/rpc';

$data = array("jsonrpc" => "2.0","method" => "theta.GetBlockByHeight","params"=>[array("height"=>"$block_num")],"id"=>"1");

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

$block = json_decode($result, true);
$timestamp = $block["result"]["timestamp"];
$transaction = $block["result"]["transactions"];
$hash = $block["result"]["hash"];
$proposer = $block["result"]["proposer"];
$parent = $block["result"]["parent"];
$state_hash = $block["result"]["state_hash"];
$count = count($transaction);
$transactions_hash = $block["result"]["transactions_hash"];
$block_num_p = $block_num - 1;
$count = count($transaction);
echo'
<html>
<head>
<title>ThetaScan.io - Block Details</title>
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
	<div class="b"> <a style="float:left;"> Block Details </a></div>
	<br><br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Height </a></div>	
	<div style="width: 980px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$block_num.' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Timestamp </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$timestamp.' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Hash </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$hash.' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Transaction Count </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$count.' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> TXNS Hash </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$transactions_hash.' </a></div>
	<br><br><hr>	
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Proposer </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$proposer.' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> State Hash </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$state_hash.' </a></div>
	<br><br><hr>
	<div style="width: 200px; float:left; padding: 10px 5px;"><a style="float:left;"> Previous Block </a></div>
	<div style="width: 980px; float:left; padding: 10px 5px;"><a style="float:left;" href="/block_details.php?height='.$block_num_p.'"> '.$parent.' </a></div>
</div>
<br><br><br>
<div class="d">
	<div class="b"> <a style="float:left;"> Transactions </a></div>
	<br><br><br>
	<div style="width: 300px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a>Type</a></div>
	<div style="width: 600px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a>Hash</a></div>
	<div style="width: 270px; float:left; padding: 10px 5px; background-color:#b5b5b5;"><a> &nbsp; </a></div>
	<br><br>
	';

for ($x = 0; $x <= $count-1; $x++) {
	$type = $transaction[$x]['type'];
	$hash = $transaction[$x]['hash'];	
	if ($type == 0) {$type_name = "Coinbase" ;}
	if ($type == 1) {$type_name = "Slash";}
	if ($type == 2) {$type_name = "Send";}
	if ($type == 3) {$type_name = "Reserve Fund";}
	if ($type == 4) {$type_name = "Release Fund";}
	if ($type == 5) {$type_name = "Service Payment";}
	if ($type == 6) {$type_name = "Split Rule";}
	if ($type == 7) {$type_name = "Smart Contract";}	
	if ($type == 10) {$type_name = "Deposit Stake";}
	if ($type == 9) {$type_name = "Withdraw Stake";}
	echo'
	<div style="width: 300px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$type_name.' </a></div>
	<div style="width: 880px; float:left; padding: 10px 5px;"><a style="float:left;" href="/hash.php?hash='.$hash.'"> '.$hash.' </a></div>
	<br><br><hr>';
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
</html>';

?>
