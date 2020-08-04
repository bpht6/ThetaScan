<?php

$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database = $config['database'];
        $api = $config['api'];
        $password = $config['password'];
        
$url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?CMC_PRO_API_KEY=".$api."&symbol=THETA,TFUEL";        
        
$con=mysqli_connect($host,$user,$password,$database);

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_TIMEOUT, 4000);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, True);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
$result = curl_exec($ch);
curl_close($ch);
$prices = json_decode($result, true);

$tfuel = $prices['data']['TFUEL']['quote']['USD']['price'];
$tfuel_24h_vol = $prices['data']['TFUEL']['quote']['USD']['volume_24h'];
$tfuel_24h_change = $prices['data']['TFUEL']['quote']['USD']['percent_change_24h'];
$tfuel_market = $prices['data']['TFUEL']['quote']['USD']['market_cap'];
$theta = $prices['data']['THETA']['quote']['USD']['price'];
$theta_24h_vol = $prices['data']['THETA']['quote']['USD']['volume_24h'];
$theta_24h_change = $prices['data']['THETA']['quote']['USD']['percent_change_24h'];
$theta_market = $prices['data']['THETA']['quote']['USD']['market_cap'];

if ($theta  != ""){
	$name = "TFUEL";
	$result = "UPDATE prices SET price='$tfuel',Volume='$tfuel_24h_vol', percent_change='$tfuel_24h_change', market='$tfuel_market' WHERE name='$name'";
	if (mysqli_query($con, $result)) {
	}

	$name = "THETA";
	$result = "UPDATE prices SET price='$theta',volume='$theta_24h_vol', percent_change='$theta_24h_change', market='$theta_market' WHERE name='$name'";
	if (mysqli_query($con, $result)) {
	}
}



?>