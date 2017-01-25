<?php
/**
*
* This file is part of the OcFeed Maker for Opencart
*
* Copyright 20016-2020 Geek Monsters All rights reserved. <http://geekmonster.com.mx>
* Released under the GPL license
* http://www.opensource.org/licenses/gpl-license.php
*
* If you want to contribute to the proyect please send an e-mail to: jatib@ciencias.unam.mx
* visit the git repository to look the wip and realte documentation 
* <https://github.com/jatib/OcFeedMaker>
*
**/
	//Head feed defined with tab

	define('SHOP_URL','index.php?route=product/product&product_id=');
	define('IMAGE_URL','image/');
	

	$head = "id\t";
	$head .= "title\t";
	$head .= "description\t";
	$head .= "google product category\t";
	$head .= "product type\t";
	$head .= "link\t";
	$head .= "image link\t";
	$head .= "condition\t";
	$head .= "availability\t";
	$head .= "price\t";
	$head .= "sale price\t";
	$head .= "sale price effective date\t";
	$head .= "gtin\t";
	$head .= "brand\t";
	$head .= "mpn\t";
	$head .= "item group id\t";
	$head .= "gender\t";
	$head .= "age group\t";
	$head .= "color\t";
	$head .= "size\t";
	$head .= "shipping\t";
	$head .= "shipping weight\t";
	$head .= "identifier_​exists\n";

	function connection($server=DB_HOSTNAME,$user=DB_USERNAME,$pass=DB_PASSWORD,$db=DB_DATABASE){

		$key = mysqli_connect($server,$user,$pass,$db)or die("Error de conexión");

		return $key;

	}

	function totalElements($key,$test=0,$prefix=DB_PREFIX){

		$query = 'SELECT * FROM '.$prefix.'product';
		$result =  mysqli_query($key,$query);
		$count = mysqli_num_rows($result);
		$fetch = mysqli_fetch_row($result);
		$data = array($count,$fetch);

		//Test code
		if($test==1){
			$titles = array("product_id","model","sku","upc","ean","jan","isbn","mpn","location","quantity","stock_status_id","image","manufacturer_id","shipping","price","points","tax_class_id","date_available","weight","weight_class_id","length","width","height","length_class_id","subtract","minimum","sort_order","status","viewed","date_added","date_modified");

			for ($i=0; $i < 31; $i++) { 
				echo "<p><b>Element[$i]->$titles[$i]:</b> $fetch[$i]</p>";
			}
		}
		//End test

		return $data;

	}

	function feedConstructor($start,$end,$key,$feedHead,$prouctIdMerchant,$filename="merchant",$prefix=DB_PREFIX){
		
		//Creating the file to write data
		$myfile = fopen($filename.".txt", "w")or die("Unable to open file!");
		fwrite($myfile,$feedHead);

		//Now extract data from the DB to an array using a descriptive name
		for ($i = $start; $i < ($end + $start ); $i++){

			//Basic info
			$product = "SELECT * FROM ".$prefix."product WHERE product_id=\"$i\"";
			$product = mysqli_query($key,$product);
			$product = mysqli_fetch_row($product);

			//Description
			$description = "SELECT * FROM ".$prefix."product_description WHERE product_id=\"$i\"";
			$description = mysqli_query($key,$description)or die('Query error');
			$description = mysqli_fetch_row($description);

			//Manufacturer
			$manufacturer = "SELECT * FROM ".$prefix."manufacturer WHERE manufacturer_id=\"$product[12]\"";
			$manufacturer = mysqli_query($key,$manufacturer);
			$manufacturer = mysqli_fetch_row($manufacturer);

			//Availability
			$availability = "SELECT * FROM ".$prefix."stock_status WHERE stock_status_id=\"product[10]\"";
			$availability = mysqli_query($key,$availability);
			$availability = mysqli_fetch_row($availability);

			//Category
			$category = "SELECT * FROM ".$prefix."product_to_category WHERE product_id=\"$i\"";
			$category = mysqli_query($key,$category);
			$category = mysqli_fetch_row($category);
			$categoryId = "SELECT * FROM ".$prefix."category_description WHERE category_id=\"category[1]$\"";
			$category = mysqli_query($key,$categoryId);
			$category = mysqli_fetch_row($category);
			$category = $category[2];

			/*Depreceated because can get that info from a last query
			$image = "SELECT * FROM ".$prefix."product_image WHERE product_id=\"$i\"";
			$image = mysqli_query($key,$image)or die('Query error');
			$image = mysqli_fetch_row($image);*/

			//Can be new or refubished
			$condition = "nuevo";

			if( $description[3] != NULL ){
				// Cleaning string to use in de feed. Delete html format.
				$html = htmlspecialchars_decode($description[3]);
				$plainText = strip_tags($html, '<p>');
				$plainText = strip_tags($plainText, '<ul>');
				$plainText = strip_tags($plainText, '<br>');
				$plainText = htmlspecialchars($plainText,ENT_SUBSTITUTE);
				$plainText = preg_replace("/&#?[a-z0-9]{2,8};/i","",$plainText); 
				$plainText = str_replace(array("\r", "\n"), ' ',$plainText);
				$plainText = str_replace(array("\r", "\t"), '',$plainText);
				// Setting cero counter to feed the array plain
				$counter = 0;
				// Setting the resting info.
				$URL = HTTP_SERVER.SHOP_URL.$description[0];
				$imageU = HTTP_SERVER.IMAGE_URL.$product[11];
				$id = $description[0].$prouctIdMerchant;
				$mpn = $product[7];
				$price = $product[14];
				$brand = $manufacturer[1];
				$stock = $availability[2];
				$category = $category[2];

				// Geting the gtin or die no
				if($product[2]!= NULL){
					$gtin = $product[2];
					$ident = "";
				}else{
					if($product[3]!= NULL){
						$gtin = $product[3];
						$ident = "";
					}else{
						if($product[4]!= NULL){
							$gtin = $product[4];
							$ident = "";
						}else{
							$gtin = "";
							$ident = "no";
						}
					}
				}

				$limit = strlen($plainText);
				
				if ($limit > 600) {
					$limit = 600;
				}
				
				for ($j=0; $j < $limit ; $j++) {

					if ((($plainText[$j]!=" ") or ($j > 5)) and $plainText[$j]!=NULL){

						$plain[$counter] = $plainText[$j];
						$counter++;

					}

				}

				$plainText = implode("",$plain);

				$feed = $id."\t"; 			// Id for Merchant
				$feed .= $description[2]."\t"; 	// Title
				$feed .= $plainText."\t"; 	// Description
				$feed .= ""."\t";			// Google product category
				$feed .= $category."\t";	// Product type
				$feed .= $URL."\t"; 		// Url to publication
				$feed .= $imageU."\t";		// Url to image
				$feed .= "new"."\t";		// Condition
				$feed .= $stock."\t";		// Availability
				$feed .= $price."\t";		// Price
				$feed .= ""."\t";			// Sale Price
				$feed .= ""."\t";			// Sale price effective date
				$feed .= $gtin."\t";		// GTIN
				$feed .= $brand."\t";		// Brand
				$feed .= $mpn."\t";			// MPN
				$feed .= $ident."\t";		// Identifier
				$feed .= "\n";				// End of line|


				fwrite($myfile,$feed)or die("Error");

			}
		}
		fclose($myfile);

		return $filename.".txt";
	}

	function feedConstructorTest($start,$end,$key,$prefix=DB_PREFIX){
		
		for ($i = $start; $i < ( $end + $start ); $i++){

			echo "\n <section style='background: #0AF;width:90%;'>";
			echo "\n <article style='width:80%;margin: 0 auto;font-size:12px;'>";

			$query = "SELECT * FROM ".$prefix."product_description WHERE product_id=\"$i\"";
			$query = mysqli_query($key,$query)or die('Query error');
			$query = mysqli_fetch_row($query);

			$image = "SELECT * FROM ".$prefix."product_image WHERE product_id=\"$i\"";
			$image = mysqli_query($key,$image)or die('Query error');
			$image = mysqli_fetch_row($image);

			if( $query != NULL ){
				//Graphic feed info supervisor
				echo "<pre style='display:inline'>$query[0] &#09;</pre>";
				echo "<pre style='display:inline'>$query[1] &#09;</pre>";
				echo "<pre style='display:inline'>$query[2] &#09;</pre>";
				$html = htmlspecialchars_decode($query[3]);
				$plainText = strip_tags($html, '<p>');
				$plainText = strip_tags($plainText, '<ul>');
				$plainText = strip_tags($plainText, '<br>');
				$plainText = htmlspecialchars($plainText,ENT_SUBSTITUTE);
				$plainText = preg_replace("/&#?[a-z0-9]{2,8};/i","",$plainText); 
				$plainText = str_replace(array("\r", "\n"), ' ',$plainText);
				$plainText = str_replace(array("\r", "\t"), '',$plainText);
//				print_r($plainText);
				$counter = 0;

				$URL = HTTP_SERVER.SHOP_URL.$query[0];
				$imageU = HTTP_SERVER.IMAGE_URL.$image[2];

				for ($j=0; $j < 1000; $j++) {

					if (($plainText[$j]!=" ") or ($j > 5)) {
						$plain[$counter] = $plainText[$j];
						$counter++;
					}
				}
				$plainText = implode("",$plain);
				//echo $plainText;
				echo "<div style='width:40%;'>$plainText &#09;</div>";
				echo "<pre style='display:inline'>$URL &#09;</pre>";
				echo "<pre style='display:inline'>$imageU &#09;</pre>";
				echo "<br><br>";
			}
			echo "</article>";
			echo "</section><br><br>";
		}
	}

