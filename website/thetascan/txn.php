<?php
$config = parse_ini_file('/var/www/config.ini');
        $network = $config['mainnet'];
echo'
<html>
<head>
<title>ThetaScan.io</title>
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
.txn {
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
<br>';


$tx_bytes = $_POST['txn_bytes'];

$url = 'http://localhost/rpc';
$data = array("jsonrpc" => "2.0","method" => "theta.BroadcastRawTransaction","params"=>[array("tx_bytes"=>"$tx_bytes")],"id"=>"1");
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

echo'<div class="d">
	<div class="b"> <a style="float:left;">Broadcast Result </a></div><br><br><hr>
	<div style="width:1200px; background-color: #ffffff;"><br>';

print_r($result);

echo'	<br><br><br>
	</div>
</div>
<br><br><br>
<div style="width:1200px;">
	<div style="float:left;"><a href="/broadcast_txn.php"> Broadcast TXN</a></div>
	<div style="float:center;"><a href="/status.php"> Node Status</a></div>
</div>
<br><br>';
?>