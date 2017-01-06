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


	include "config.php";
	include "functions.php";
	foreach ( glob("/google/*.php") as $filename){
		include $filename;
	}

	/*Her we define the database variables to do the querys*/
	/*$user = DB_USERNAME;
	$password = DB_PASSWORD;
	$host = DB_HOSTNAME;
	$DB = DB_DATABASE;
	$prefix = DB_PREFIX;
	$baseURL = HTTP_SERVER;*/
	$baseURL = $baseURL."index.php?route=product/product&product_id=";

	echo "<h1>TEST</h1>";

	/*Now, we go to count all the products in the database*/
	
	$data = totalElements();
	/*print_r($data);*/
	$start = $data[1][0];
	/*echo "<br>$start<br>";*/
	$stop = $data[0];
	/*echo "<br>$stop<br>";*/

	/*Now create the Feed*/

	feedConstructor($start,$stop);

	//echo "$cuentaSC";



?>