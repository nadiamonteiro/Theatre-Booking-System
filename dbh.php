<?php
	function connect() {
	$host = 'dragon.kent.ac.uk';
	$dbname = 'njm59';
	$user = 'njm59';
	$pwd = 'mbu-shk';
	
	try {
		$conn = new PDO("mysql:host=$host; dbname=$dbname", $user, $pwd);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if ($conn) {
			return $conn;
		} else {
			echo 'Failed to connect';
		}
	} catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
	
	}
?>