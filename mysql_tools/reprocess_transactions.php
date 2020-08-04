<?php

$url = 'http://localhost/rpc';

$data_current = array("jsonrpc" => "2.0","method" => "theta.GetStatus","params"=>[],"id"=>"1");

$postdata = json_encode($data_current);
$config = parse_ini_file('/var/www/config.ini');
        $host = $config['host'];
        $user = $config['user'];
        $database2 = $config['database2'];
        $utilpass = $config['utilpass'];
        $password = $config['password'];
        $network = $config['mainnet'];
        
$s_block = $_POST['start'];
$e_block = $_POST['end'];
$number = $e_block - $s_block;

if ($utilpass == $_POST['pass']){
	echo '<b>Password Valid</b><br><br>
	Coinbase Delete Transactions <br><br>
	Start Block: '.$s_block.'<br><br>
	End Block: '.$e_block.'<br><br>
	Total Blocks to Reprocessed: '.$number.'<br><br>
	';
	}else{
	echo "<b>Password Invalid<b>";
	exit(0);
	}

if ($s_block < 1){echo " Error: Start block not Valid"; exit(0);}

if ($e_block < 1){echo " Error: End Block not Valid"; exit(0);}

if ($e_block < $s_block) {echo " Error: Start Block Larger then end block"; exit(0);}

if ($e_block - $s_block > 500000) {
echo " Too many blocks processed at one time (Max 500,000) <br>";
exit(0);

}
$con=mysqli_connect($host,$user,$password,$database2);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

for ($block_num = $s_block; $block_num <= $e_block; $block_num++) {
	if (substr($block_num, -3) == "000"){
	echo $block_num."<br>";
	ob_flush();
	flush();
	}
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
	$count = count($transaction);


	for ($x = 0; $x <= $count-1; $x++) {
		$output_count = count($transaction[$x]['raw']['outputs']);
		$fee_thetawei = $transaction[$x]['raw']['fee']['thetawei'];
		$fee_tfuelwei = $transaction[$x]['raw']['fee']['tfuelwei'];
		$add_from = $transaction[$x]['raw']['inputs'][0]['address'];
		$sequence = $transaction[$x]['raw']['inputs'][0]['sequence'];
		$type = $transaction[$x]['type'];
		$hash = $transaction[$x]['hash'];

		if ($type == 2){
			for ($z = 0; $z <= $output_count-1; $z++) {
				$sent_thetawei = $transaction[$x]['raw']['outputs'][$z]['coins']['thetawei'];
				$sent_tfuelwei = $transaction[$x]['raw']['outputs'][$z]['coins']['tfuelwei'];
				$add_to = $transaction[$x]['raw']['outputs'][$z]['address'];
				$result = "INSERT INTO transactions (block,fee_thetawei,fee_tfuelwei,add_from,sent_thetawei,sent_tfuelwei,add_to,type,hash,timestamp,sequence) Values ('$block_num','$fee_thetawei','$fee_tfuelwei','$add_from','$sent_thetawei','$sent_tfuelwei','$add_to','$type','$hash','$timestamp','$sequence')";
				if (mysqli_query($con, $result)) {
				}
			}
		}

		if ($type == 0){
			for ($z = 0; $z <= $output_count-1; $z++) {
				$add_to = $transaction[$x]['raw']['outputs'][$z]['address'];
				$tfuel_payout= $transaction[$x]['raw']['outputs'][$z]['coins']['tfuelwei'];
				$compressed = "0";
				$result1 = "INSERT INTO coinbase (timestamp,block,address,tfuel,compressed) Values ('$timestamp','$block_num','$add_to','$tfuel_payout','$compressed')";
				if (mysqli_query($con, $result1)) {
				}
			}
		}

	}
}

echo "<br><br> Completed <br><br>";

?>