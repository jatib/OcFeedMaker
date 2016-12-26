<!--
@Author: Jatib (jatib@ciencias.uanm.mx)
@Licence: GNU GENERAL PUBLIC LICENSE Version 3.
-->
<!DOCTYPE html>
<html>
<head>
	<title>Testing</title>
</head>
<body>
	<section class="panel" style="margin:0 auto;width: 80%;">
	<h1 id="demo">Merchant Feed Maker</h1>
	<h3>For OpenCart, make a txt file compatible with the Google Merchant Center<br>to be refered on the feed configuration.</h3>
	<p>Please, bring your database info to do the feed.</p>
		<article class="form">
			<form method="POST" action="">
				<label>User</label><br>
				<input type="text" name="user" required><br><br>
				<label>Password</label><br>
				<input type="password" name="password" required><br><br>
				<label>Host</label><br>
				<input type="text" name="host" required><br><br>
				<label>Database</label><br>
				<input type="text" name="database" required><br><br>
				<label>Table prefix</label><br>
				<input type="text" name="table" style="color:#0F0F0F;" value="oc_(by default)" required><br><br>
				<label>Base URL</label><br>
				<details style="font-size:10px;">To do the whole URL details</details><br>
				<input type="text" name="URL" style="color:#0F0F0F;" required><br><br>
				<label>Merchant ID</label><br>
				<input type="text" name="merchantID" style="color:#0F0F0F;" required><br><br>
				<input type="submit" name="send" value="entrar">
			</form>
		</article>
	</section>

	<section>
	<?php

		include("conexion.php");

		if( isset($_POST["user"]) ){

			$user = $_POST['user'];
			$pass = $_POST['password'];
			$host = $_POST['host'];
			$bd = $_POST['database'];
			$prouctIdMerchant = $_POST['merchantID'];
			$querySc = 'SELECT * FROM oc_test_product';
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

				echo '<section style="background: #0AF;width:90%;">';
				echo "<article style='width:80%;margin: 0 auto;font-size:12px;'>";
				if( $queryRow != NULL ){

					//Graphic feed info supervisor
					fwrite($myfile, $queryRow[0].$prouctIdMerchant."\t".$queryRow[2]."\t".$baseURL.$queryRow[0]."\n");
					echo "<h1>Product ID:".$queryRow[0]."</h1>";
					echo "<h1>".$queryRow[1]."</h1>";
					echo "<h1>".$queryRow[2]."</h1>";
       				echo htmlspecialchars_decode($queryRow[3]);
					echo "<br><br>";
				}
				echo "</article>";
				echo "</section><br><br>";
			} 
			fclose($myfile);	
		}
	
	?>
	</section>

</body>
</html>
