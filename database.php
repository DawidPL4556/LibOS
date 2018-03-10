<?php

	$db_config = require_once "config.php";
	
	try
	{
		$database = new PDO("mysql:host={$db_config['host']};dbname={$db_config['database']};charset=utf8", $db_config['user'], $db_config['password'],
		[
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);
	} catch (PDOException $err){
		echo "Database Error.";
		exit('');
	}

?>