<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..//");
$dotenv->load();

$DB_HOST = $_ENV["DB_HOST"];
$DB_NAME = $_ENV["DB_NAME"];
$DB_USER = $_ENV["DB_USER"];
$DB_PASS = $_ENV["DB_PASS"];

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

function createTabelDataset() {
	global $conn;

	$query = "CREATE TABLE IF NOT EXISTS `dataset` (
			id INT PRIMARY KEY AUTO_INCREMENT,
			kecamatan VARCHAR(255),
			desa VARCHAR(255),
			nama_bumdes VARCHAR(255),
			status_badan_hukum INT(1),
			lama_usaha INT(6),
			jml_unit_usaha INT(6),
			total_modal FLOAT,
			perkembangan_modal FLOAT,
			selisih_modal FLOAT,
			klasifikasi VARCHAR(20)
	)";

	return $conn->query($query);
}

function createTabelHasilHitung() {
	global $conn;

	$query = "CREATE TABLE IF NOT EXISTS `hasil_hitung` (
			id INT PRIMARY KEY AUTO_INCREMENT,
			kecamatan VARCHAR(255),
			desa VARCHAR(255),
			nama_bumdes VARCHAR(255),
			status_badan_hukum INT(1),
			lama_usaha INT(6),
			jml_unit_usaha INT(6),
			total_modal FLOAT,
			perkembangan_modal FLOAT,
			selisih_modal FLOAT,
			klasifikasi VARCHAR(20),
			nilai_k INT
	)";

	return $conn->query($query);
}


createTabelDataset();
createTabelHasilHitung();

die(print("Database telah di set.\n"));