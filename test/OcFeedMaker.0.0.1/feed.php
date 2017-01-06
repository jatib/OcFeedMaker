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
	
	/*Her we define the database variables to do the querys*/

	$key = connection();
	$data = totalElements($key);
	$start = $data[1][0];
	$stop = $data[0];
	
	$test = 0;

	$file = feedConstructor($start,$stop,$key,$head);

	/*Now create the Feed*/
	if($test == 1){
		echo "<h1>Test in progress</h1>";
		echo "<h1>$baseURL</h1>";
		echo "<h3>$start</h3>";
		echo "<h3>$stop</h3>";
		feedConstructorTest($start,$stop,$key);
		echo "<h1>Test sucesse</h1>";
	}
	else{
		header('Location: '.HTTP_SERVER.$file);
	}
	//echo "$cuentaSC";

?>