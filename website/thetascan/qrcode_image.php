<?php

require_once("qrcode.php");
$address = $_GET['address'];

$qr = QRCode::getMinimumQRCode($address, QR_ERROR_CORRECT_LEVEL_H);


$im = $qr->createImage(10, 10);

header("Content-type: image/gif");
imagegif($im);

imagedestroy($im);

?>