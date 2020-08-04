<?php

$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database2 = $config['database2'];
        $utilpass = $config['utilpass'];
        $password = $config['password'];

$start = $_POST['start'];
$end = $_POST['end'];
$number = $end - $start;

if ($utilpass == $_POST['pass']){
	echo '<b>Password Valid</b><br><br>
	Coinbase Delete Transactions <br><br>
	Start Block: '.$start.'<br><br>
	End Block: '.$end.'<br><br>
	Total Blocks to be Deleted: '.$number.'<br><br>
	';
	}else{
	echo "<b>Password Invalid<b>";
	exit(0);
	}
        
$con=mysqli_connect($host,$user,$password,$database2);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = "DELETE FROM coinbase WHERE block >= '$start' and block <= '$end'";
if (mysqli_query($con, $result)) {}

echo "Transactions Deleted";
?>