<?php
 
$network = $_GET['network'];

if ($network == "main_net") {echo'<script>window.location.href = "/";</script>';}
if ($network == "test_net") {echo'<script>window.location.href = "/test_net/";</script>';}

echo $network;

?>