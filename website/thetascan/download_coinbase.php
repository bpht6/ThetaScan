<?php
$address = $_GET["address"];
$year = $_GET["year"];

$next_year = $year + 1;
$jan = strtotime("01/01/".$year);
$dec = strtotime("01/01/".$next_year);

$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database2 = $config['database2'];
        $password = $config['password'];

$con1=mysqli_connect($host,$user,$password,$database2);
if (mysqli_connect_errno()) {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$download[0][0] = "Date";
$download[0][1] = "Time (UTC)";
$download[0][2] = "Block";
$download[0][3] = "TFuel";
$download[0][4] = "Address: ".$address;
$a=1;

$result = mysqli_query($con1, "SELECT timestamp,block,address,tfuel FROM coinbase WHERE timestamp >= '$jan' and timestamp < '$dec' and address = '$address' ORDER BY block DESC LIMIT 60000");
{  
	while($row = mysqli_fetch_array($result)) {
		$download[$a][0] = date("Y/m/d", $row['timestamp']);
		$download[$a][1] = date("h:i:sa", $row['timestamp']);
		$download[$a][2] = $row['block'];
		$download[$a][6] = $row['tfuel']/1000000000000000000;
		$a++;
	}
}


header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=Coinbase_Export.csv");
$fileoutput = fopen('php://output', 'w');
foreach ($download as $rows) {
	fputcsv($fileoutput, $rows);
}

?>

