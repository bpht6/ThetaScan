<?php

$address = $_POST['address'];

$url = 'http://localhost/rpc';
$data = array("jsonrpc" => "2.0","method" => "theta.GetAccount","params"=>[array("address"=>"$address")],"id"=>"1");
$postdata = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_PORT, 16888);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
curl_close($ch);

echo "<b>Return API JSON Output: </b><br>";
//header('Content-type: application/json');
print_r($result);

echo "<br><br><b>Return only address, Theta, and TFuel balance seperated by comma: </b><br>";
$balance = json_decode($result, true);
echo $address.','.$balance['result']['coins']['thetawei'].','.$balance['result']['coins']['tfuelwei'];

echo "<br><br><b>Return only address, Theta, and TFuel balance in JSON format: </b><br>";
//header('Content-type: application/json');
echo '{"address":"'.$address.'","thetawei":"'.$balance['result']['coins']['thetawei'].'","tfuelwei":"'.$balance['result']['coins']['tfuelwei'].'"}';

echo "<br><br><b>Another way to ensode to JSON format: </b><br>";
//header('Content-type: application/json');
$array['address']=$address;
$array['thetawei']=$balance['result']['coins']['thetawei'];
$array['tfuelwei']=$balance['result']['coins']['tfuelwei'];
echo json_encode($array);

echo "<br><br>You can use a post command to the php file to get back the desired infomation formated differently.<br> An example of this would be a Apple Iphone app needs a balance from a Theta address.<br>
The app can send a post to the php file then returned the required information.<br><br>

<a href='index.html'>Back to more examples </a>
";
?>