<?php

	function connect($host,$usuario,$pass,$bd){
	
	$connection = mysqli_connect($host,$usuario,$pass,$bd);
	if(!$connection){
		die("Error en la conexión ".mysqli_connect_error());
	}

	return $connection;
}