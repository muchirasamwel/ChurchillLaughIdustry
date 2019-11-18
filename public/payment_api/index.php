<?php 
	require 'Payment_class.php';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	//init mpesa
	$mpesa=new Mpesa();
	//echo "<br>regUrl<br>".$mpesa->accessToken." <br>";
	$resp=$mpesa->regUrl();
	echo "registering url <br>";
	echo $resp."<br>";
	echo "<br>simulation<br>";
	$resp=$mpesa->simulateTrans(100);
	echo $resp;
 ?>
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Mpesa api</title>
 </head>
 <body>
 	<h1>Mpesa api</h1>
 	<p>Currently integrating my php with mpesa api</p>
 	<?php 
 		echo "working";
 	 ?>
 </body>
 </html>