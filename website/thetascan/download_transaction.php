<?php
$address = $_GET["address"];
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
$download[0][3] = "Hash";
$download[0][4] = "Sending Address";
$download[0][5] = "Recieving Address";
$download[0][6] = "Theta Sent";
$download[0][7] = "TFuel Sent";
$download[0][8] = "Transaction Export Limited to 50000 most recent";
$a=1;
$result = mysqli_query($con1, "SELECT block,type,hash,add_to,add_from,sent_thetawei,sent_tfuelwei,timestamp FROM transactions WHERE (add_to = '$address' OR add_from = '$address') ORDER BY block DESC LIMIT 50000");
{  
	while($row = mysqli_fetch_array($result)) {
		$download[$a][0] = date("Y/m/d", $row['timestamp']);
		$download[$a][1] = date("h:i:sa", $row['timestamp']);
		$download[$a][2] = $row['block'];
		$download[$a][3] = $row['hash'];
		$download[$a][4] = $row['add_from'];
		$download[$a][5] = $row['add_to'];
		$download[$a][6] = $row['sent_thetawei']/1000000000000000000;
		$download[$a][7] = $row['sent_tfuelwei']/1000000000000000000;
		$a++;
	}
}

header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=transaction_export.csv");
$fileoutput = fopen('php://output', 'w');
foreach ($download as $rows) {	
	fputcsv($fileoutput, $rows);
}

?>