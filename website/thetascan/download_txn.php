<?php

$config = parse_ini_file('/var/www/config.ini');
        $network = $config['mainnet'];
$hash = $_GET['hash'];

header('Content-type: application/json');
//header('Content-Disposition: inline; filename='.$hash.'.json');
$url = 'http://localhost/rpc';
$data = array("jsonrpc" => "2.0","method" => "theta.GetTransaction","params"=>[array("hash"=>"$hash")],"id"=>"1");
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
echo($result);

?>