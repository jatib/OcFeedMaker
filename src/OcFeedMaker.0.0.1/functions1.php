<?php
/**
*
* This file is part of the OcFeed Maker for Opencart
*
* Copyright 20016-2020 Geek Monsters, Ltd. All rights reserved. <http://geekmonster.com.mx>
* Released under the GPL license
* http://www.opensource.org/licenses/gpl-license.php
*
* If you want to contribute to the proyect please send an e-mail to: jatib@ciencias.unam.mx
* visit the git repository to look the wip and realte documentation 
* <https://github.com/jatib/OcFeedMaker>
*
**/
	/*Head feed defined with tab*/
	$feedHead = "id\t";$feedHead .= "title\t";
	$feedHead .= "description\t";$feedHead .= "google product category\t";
	$feedHead .= "product type\t";$feedHead .= "link\t";
	$feedHead .= "image link\t";$feedHead .= "condition\t";
	$feedHead .= "availability\t";$feedHead .= "price\t";
	$feedHead .= "sale price\t";$feedHead .= "sale price effective date\t";
	$feedHead .= "gtin\t";$feedHead .= "brand\t";
	$feedHead .= "mpn\t";$feedHead .= "item group id\t";
	$feedHead .= "gender\t";$feedHead .= "age group\t";
	$feedHead .= "color\t";$feedHead .= "size\t";
	$feedHead .= "shipping\t";$feedHead .= "shipping weight\n";


	function feedConstructorTest($start,$end,$host = DB_HOSTNAME,$user = DB_USERNAME,$pass = DB_PASSWORD,$DB = DB_DATABASE,$filename = "merchant",$prefix = DB_PREFIX,$feedHead = $feedHead){
		
		for ($j = $start; $j < ($end + $start ); $j++){
		
		}
	}

	function feedConstructor($start,$end,$host = DB_HOSTNAME,$user = DB_USERNAME,$pass = DB_PASSWORD,$DB = DB_DATABASE,$filename = "merchant",$prefix = DB_PREFIX,$feedHead = $feedHead){
		
		$myfile = fopen($filename."txt", "w")or die("Unable to open file!");
		fwrite($myfile,$feedHead);
		for ($j = $start; $j < ($end + $start ); $j++){
			$key = mysqli_connect($host,$user,$pass,$DB) or die("Error de conexión");
			$query = "SELECT * FROM ".$prefix."product_description WHERE product_id=\"$j\"";
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
	}

	/**/
	function totalElements($host = DB_HOSTNAME,$user = DB_USERNAME,$pass = DB_PASSWORD,$DB = DB_DATABASE,$prefix = DB_PREFIX){

		$query = 'SELECT * FROM '.$prefix.'product';
		$key = mysqli_connect($host,$user,$pass,$DB) or die("Error de conexión");
		$result =  mysqli_query($key,$query);
		$count = mysqli_num_rows($result);
		$fetch = mysqli_fetch_row($result);
		$data = array($count,$fetch);
		return $data;
	}

?>