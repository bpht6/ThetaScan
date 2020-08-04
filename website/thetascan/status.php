<?php

$url = 'http://localhost/rpc';
$data = array("jsonrpc" => "2.0","method" => "theta.GetStatus","params"=>[array("address"=>"$address")],"id"=>"1");
$postdata = json_encode($data);

$config = parse_ini_file('/var/www/config.ini');
        $network = $config['mainnet'];

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

$node_height= $details['result']['latest_finalized_block_height'];
$current_height= $details['result']['current_height'];
$syncing= $details['result']['syncing'];
if (($current_height - $node_height) < 20 ) {$syncing1 = "Node is online and in sync";} else {$syncing1 = "Node out of sync with network";}
if ($current_height == "") {$syncing1 = "Node Offline";}
$hours_to_sync = number_format(($current_height - $node_height)/4400,2);

echo'


<html>
<head>
<title>ThetaScan.io - Node Status</title>
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
	<div class="b"> <a style="float:left;"> Node Status </a></div>
	<br><br><HR>
	<div style="width: 220px; float:left; padding: 10px 5px;"><a style="float:left;"> Status </a></div>
	<div style="width: 960px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$syncing1.' </a></div>
	<br><br><hr>
	<div style="width: 220px; float:left; padding: 10px 5px;"><a style="float:left;"> Node Height</a></div>
	<div style="width: 960px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$node_height.'</a></div>
	<br><br><hr>
	<div style="width: 220px; float:left; padding: 10px 5px;"><a style="float:left;"> Current Finalized Height</a></div>
	<div style="width: 960px; float:left; padding: 10px 5px;"><a style="float:left;"> '.$current_height.' </a></div>
	<br><br><hr>
	<div style="width: 220px; float:left; padding: 10px 5px;"><a style="float:left;"> Estimated Time To Sync</a></div>
	<div style="width: 960px; float:left; padding: 10px 5px;"><a style="float:left;"> About '.$hours_to_sync.' hours to sync </a></div>
	<br><br><hr>
	<div style="width: 220px; float:left; padding: 10px 5px;"><a style="float:left;"> Percentage Complete</a></div>
	<div style="width: 960px; float:left; padding: 10px 5px;"><a style="float:left;"> '.number_format(($node_height/$current_height)*100,2).' % </a></div>
</div>
<br><br><br>
<div style="width:1200px;">
	<div style="float:left;"><a href="/broadcast_txn.php"> Broadcast TXN</a></div>
	<div style="float:center;"><a href="/status.php"> Node Status</a></div>
</div>
<br><br><br>
Version 1.01.00
<br><br>
</center>
</body>
</html>';

?>