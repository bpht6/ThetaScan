<?php
$address = $_GET["address"];

echo'
<html>
<head>
<title>ThetaScan.io - Error</title>
<style>
a.a {
        font-family: Georgia, Times, Times New Roman, serif;
        font-size: 2.1em;
        color:#005eff;
        float: left;
        display: block;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
}
a.b {

        font-family: Georgia, Times, Times New Roman, serif;
}
body {
        background-color: #ebebeb;
        font-family: Gill Sans, Gill Sans MT, Calibri, sans-serif; 
}

div.a {
        background-color: #ffffff;
        width: 1200px;
        height: 210px;
        display: inline-block;
}
div.b {
        float: left;  
        font-size: 20px;
        display: block;
        padding: 10px 5px;
}
}
div.c {
        float: left;  
        font-size: 12px;
        display: block;
        padding: 10px 5px;
}
div.d {
        background-color: #ffffff;
        width: 1200px;
        display: inline-block;
}
div.e {
        background-color: #ffffff;
        width: 400px;
        height: 210px;
        display: inline-block;
}
a:link {
  text-decoration: none;
  color: black;
}

a:visited {
  text-decoration: none;
  color: black;
}

a:hover {
  text-decoration: none;
  color: black;
}

a:active {
  text-decoration: none;
  color: black;
}
.menu a.b {
        float: left;
        display: block;
        color: black;
        text-align: center;
        padding: 26px 16px;
        text-decoration: none;
        font-size: 20px;
}
.menu a.c {
        float: left;
        display: block;
}

.menu {
        overflow: hidden;
        background-color: #ebebeb;
        width: 1200px;
}
.menu .search{
        float: right;
}
.menu input[type=text] {
        padding: 6px;
        margin-top: 20px;
        font-size: 17px;
        border: none;
}
.menu .search button {
        float: right;
        padding: 6px 10px;
        margin-top: 20px;
        margin-right: 16px;
        background-color: #005eff;
        color: #ffffff;
        font-size: 17px;
        border: none;
        cursor: pointer;
}
hr {
        height: 2px;
        background-color: #ccc;
        border: none;
}
select{

 float: right;
        padding: 6px 10px;
        margin-top: 4px;
        margin-right: 0px;
        background-color: #005eff;
        color: #ffffff;
        font-size: 17px;
        border: none;
}
</style>
</head>
<body>

<center>
<div class="menu">
  <a class="c"> <img src="/theta.jpg"> </a>
  <a class="a" href="/"> ThetaScan.io</a>
  <a class="b" href="/blocks.php">Blocks</a>
  <a class="b" href="/staking.php">Staking Addresses</a>
  <div class="search">
          <form action="/address.php">
                  <input type="text" placeholder="Enter Address / Transaction Hash" name="address" size="35">
                  <button type="submit">Search</button>
          </form>
  </div>
  <div>
     <form action="/network.php">
  	<select name = "network"onchange="this.form.submit()">
  		<option value="main_net">Main Net</option>
  		<option value="test_net">Test Net</option>
	</select>
     </form>
  </div>
</div>
<br>


<br>
<h1> The address or hash you entered does not appear to be valid. </h1>
<h1> Please try again. </h1><br>
<h3> Address/Hash: '.$address.' </h3>
<br><br> If the Address/Hash is valid please check the staus of the node here: <a href="/status.php"> Node Status</a> <br><br> Our node may not be up to date.

<br><br><br>
<div style="width:1200px;">
	<div style="float:left;"><a href="/broadcast_txn.php"> Broadcast TXN</a></div>
	<div style="float:center;"><a href="/status.php"> Node Status</a></div>
</div>
<br><br>
</center>


</body>
</html>';

?>