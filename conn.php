<?php

$host = "localhost";
$dbName = "getirme";
$root = "root";
$psw = "";

try {
	$dbconn = new PDO("mysql:host=$host;dbname=$dbName", $root, $psw) or
		die("baglanti olmadi.");
} catch (PDOException $e) {
	echo "hata: " . $e;
}

?>