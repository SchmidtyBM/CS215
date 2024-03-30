<?php
	$db_host = "localhost";
	$db_user = "fvc524";  
	$db_pwd = "fvcJID6!"; 
	$db_db = "fvc524";

	$charset = 'utf8mb4';
	$attr = "mysql:host=$db_host;dbname=$db_db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
?>