<?php

$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database2 = $config['database2'];
        $password = $config['password'];
        
        
$con=mysqli_connect($host,$user,$password,$database2);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT number, last_block FROM block");
{  
	while($row = mysqli_fetch_array($result)) {
		if ($row['last_block'] == "last_block"){
			$current_block = $row['number'];
		}
		if ($row['last_block'] == "last_coinbase"){
			$current_coinbase = $row['number'];
		}
	}
}
$new_coinbase = substr($current_block, 0, -2)."01";

if ($current_block - $current_coinbase > 128){}else{exit(0);}
$last_coinbase = "last_coinbase";
$result = "UPDATE block SET number = '$new_coinbase' WHERE last_block = '$last_coinbase'";
{
	if (mysqli_query($con, $result)) {
	}
}

$date = new Datetime("now");
$now = $date->format("U");
$week = $now - (86400*7);

$result = mysqli_query($con, "SELECT MAX( timestamp ) AS maximum FROM coinbase");
{  
	while($row = mysqli_fetch_array($result)) {
		$max_timestamp = $row['maximum'];
	}
}

$result = mysqli_query($con, "SELECT * FROM guardian ORDER BY block ASC") ;
{  
	while($row = mysqli_fetch_array($result)) {
		$address = $row['address'];
		$node = $row['node'];
		if (array_key_exists($address,$guardian1)){
			if ($row['type'] == 10){$guardian1[$address][$node] =  $row['theta']/1000000000000000000 + $guardian1[$address][$node];}
			else if ($row['type'] == 9){
				if ($row['timestamp'] > $week){
					$withdraw[$address][1]=$guardian1[$address][$node]; 
					$withdraw[$address][2]=$row['timestamp']; 
				}
				$guardian1[$address][$node] = 0;
			}
		}
		else {
			if ($row['type'] == 10){$guardian1[$address][$node] =  $row['theta']/1000000000000000000;}
			if ($row['type'] == 9){
				 if ($row['timestamp'] > $week){$withdraw[$address][1]=$guardian1[$address][$node]; $withdraw[$address][2]=$row['timestamp']; }

			$guardian1[$address][$node] = 0;
			}
		}
	}
}
foreach ($guardian1 as $wallet_add => $theta_value) {
	foreach ($guardian1[$wallet_add] as $node => $value) {
		$guardian[$wallet_add] = $guardian[$wallet_add]+$value;
	}
}

arsort($guardian);
$result = mysqli_query($con, "SELECT address,timestamp,tfuel FROM coinbase WHERE timestamp = '$max_timestamp'");
{  
	while($row = mysqli_fetch_array($result)) {
		$address = $row['address'];
		if ($row['tfuel'] > 1){
			$staking[$address] =  $guardian[$address];
		}else{
		}
	}
}
arsort($staking);
arsort($withdraw);

foreach ($guardian as $wallet_add => $theta_value) {
	if (array_key_exists($wallet_add,$staking)){}else{
		if ($theta_value > 1) {
			$inactive[$wallet_add] = $theta_value;
		}
	}
}
 
$withdraw_text = "withdraw";
$result = mysqli_query($con, "SELECT address FROM staking_wallets WHERE status !='$withdraw_text'");
{  
	while($row = mysqli_fetch_array($result)) {
		$address = $row['address'];
		$old_wallets[$address] = "0";
	}
}

$result = mysqli_query($con, "SELECT address FROM staking_wallets WHERE status ='$withdraw_text'");
{  
	while($row = mysqli_fetch_array($result)) {
		$address = $row['address'];
		$withdraw_wallets[$address] = "0";
	}
}

$process = 0;
$result = "UPDATE staking_wallets SET process='$process' WHERE status !='$withdraw_text'";
if (mysqli_query($con, $result)) {}

$process = 1;
$status = "active";
foreach ($staking as $wallet_add => $theta_value) {
	if (array_key_exists($wallet_add,$old_wallets)){
		$result = "UPDATE staking_wallets SET status='$status', theta='$theta_value', process='$process', timestamp='$now'  WHERE address='$wallet_add'";
		if (mysqli_query($con, $result)) {}
	}else{
		$result1 = "INSERT INTO staking_wallets (address,theta,status,timestamp,process) Values ('$wallet_add','$theta_value','$status','$now','$process')";
		if (mysqli_query($con, $result1)) {}
	}
}

$status = "inactive";
foreach ($inactive as $wallet_add => $theta_value) {
	if (array_key_exists($wallet_add,$old_wallets)){
		$result = "UPDATE staking_wallets SET status='$status', theta='$theta_value', process='$process', timestamp='$now'  WHERE address='$wallet_add'";
		if (mysqli_query($con, $result)) {}
	}else{
		$result1 = "INSERT INTO staking_wallets (address,theta,status,timestamp,process) Values ('$wallet_add','$theta_value','$status','$now','$process')";
		if (mysqli_query($con, $result1)) {}
	}
}



$status = "withdraw";
foreach ($withdraw as $wallet_add => $theta_value) {
	$theta_v = $withdraw[$wallet_add][1];
	$timestamp_1 = $withdraw[$wallet_add][2];
	if (array_key_exists($wallet_add,$withdraw_wallets)){
	}else{
		$result1 = "INSERT INTO staking_wallets (address,theta,status,timestamp,process) Values ('$wallet_add','$theta_v','$status','$timestamp_1','$process')";
		if (mysqli_query($con, $result1)) {}
	}
}

$process = 0;
$result = "DELETE FROM staking_wallets WHERE status='$status' and timestamp < $week";
if (mysqli_query($con, $result)) {}

$result = "DELETE FROM staking_wallets WHERE process='$process'";
if (mysqli_query($con, $result)) {}


?>