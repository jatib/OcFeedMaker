<?php

	include "config.php";

	$user = DB_USERNAME;
	$pass = DB_PASSWORD;
	$host = DB_HOSTNAME;
	$bd = DB_DATABASE;
	$prouctIdMerchant = $_POST['merchantID'];
	$prefix = $_POST['tablePrefix'];
	$querySc = 'SELECT * FROM '.$prefix.'product';
	$baseURL = $_POST['URL'];
	$key = connect($host,$user,$pass,$bd);	
	$doQuery =  mysqli_query($key,$querySc);
	$cuentaSC = mysqli_num_rows($doQuery);
	$cuentaScFetch = mysqli_fetch_row($doQuery);
	$beginParam = $cuentaScFetch[0];

	$myfile = fopen("merchant.csv", "w")or die("Unable to open file!");

			//echo "$cuentaSC";
	$feedHead = "id\ttitle\tdescription\tgoogle product category\tproduct type\tlink\timage link\tcondition\tavailability\tprice\tsale price\tsale price effective date\tgtin\tbrand\tmpn\titem group id\tgender\tage group\tcolor\tsize\tshipping\tshipping weight\n";

	fwrite($myfile, $feedHead);


	for ($j = $beginParam; $j < ($cuentaSC + $beginParam ); $j++){

		
		$query = "SELECT * FROM oc_test_product_description WHERE product_id=\"$j\"";
		$result = mysqli_query($key,$query);
		$queryRow = mysqli_fetch_row($result);

		echo "\n <section style='background: #0AF;width:90%;'>";
		echo "\n <article style='width:80%;margin: 0 auto;font-size:12px;'>";
		if( $queryRow != NULL ){

			//Graphic feed info supervisor
			fwrite($myfile, $queryRow[0].$prouctIdMerchant."\t".$queryRow[2]."\t".$baseURL.$queryRow[0]."\n");
			echo "<h1>Product ID:".$queryRow[0]."</h1>\n";
			echo "<h1>".$queryRow[1]."</h1>\n";
			echo "<h1>".$queryRow[2]."</h1>";
				echo "<br>";
				$html = htmlspecialchars_decode($queryRow[3]);
				$plainText = strip_tags($html, '<p>');
				$plainText = strip_tags($plainText, '<ul>');
				$plainText = strip_tags($plainText, '<br>');
				$plainText = htmlspecialchars($plainText,ENT_SUBSTITUTE);
				$plainText = preg_replace("/&#?[a-z0-9]{2,8};/i","",$plainText); 
				$plainText = str_replace(array("\r", "\n"), ' ',$plainText);
				$plainText = str_replace(array("\r", "\t"), '',$plainText);
				echo "\n";
				echo "\n";
				echo $plainText;
				echo "\n";
			echo "<br><br>";
			echo "\n";
		}
		echo "</article>";
		echo "</section><br><br>";
	} 
	fclose($myfile);


?>