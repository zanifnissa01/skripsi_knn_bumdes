<?php

define('DB_HOST', $_ENV["DB_HOST"]);
define('DB_NAME', $_ENV["DB_NAME"]);
define('DB_USER', $_ENV["DB_USER"]);
define('DB_PASS', $_ENV["DB_PASS"]);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

function tambahData($data, $namaTabel) {
	global $conn;

	$query = "INSERT INTO `".$namaTabel."` (
	kecamatan, 
	desa, 
	nama_bumdes, 
	status_badan_hukum, 
	lama_usaha, 
	jml_unit_usaha, 
	total_modal, 
	perkembangan_modal, 
	selisih_modal, 
	klasifikasi) 
	VALUES (
	'".$data[0]."',
	'".$data[1]."',
	'".$data[2]."',
	".$data[3].",
	".$data[4].",
	".$data[5].",
	".$data[6].",
	".$data[7].",
	".$data[8].",
	'".$data[9]."')";
	// echo $query;
	return $conn->query($query) === TRUE ? true : $conn->error;
}

function ambilSemuaDataset() {
	global $conn;

	$data = [];
	$query = "SELECT * FROM `dataset`";
	$hasil = $conn->query($query);

	if ($hasil->num_rows > 0) {
		while ($barisData = $hasil->fetch_assoc()) {
			$data[] = $barisData;
		}
	}

	return $data;
}


function tambahDataset($dataPost) {
	global $conn;
	
	$kecamatan = htmlspecialchars($dataPost["kecamatan"]);
	$desa = htmlspecialchars($dataPost["desa"]);
	$nama_bumdes = htmlspecialchars($dataPost["nama_bumdes"]);
	$status_badan_hukum = htmlspecialchars($dataPost["status_badan_hukum"]);
	$lama_usaha = htmlspecialchars($dataPost["lama_usaha"]);
	$jml_unit_usaha = htmlspecialchars($dataPost["jml_unit_usaha"]);
	$total_modal = htmlspecialchars($dataPost["total_modal"]);
	$perkembangan_modal = htmlspecialchars($dataPost["perkembangan_modal"]);
	$selisih_modal = htmlspecialchars($dataPost["selisih_modal"]);
	$klasifikasi = htmlspecialchars($dataPost["klasifikasi"]);

	$query = "INSERT INTO `dataset` (id, kecamatan, desa, nama_bumdes, status_badan_hukum, lama_usaha, jml_unit_usaha, total_modal, perkembangan_modal, selisih_modal, klasifikasi) VALUES (null, '$kecamatan', '$desa', '$nama_bumdes', '$status_badan_hukum', '$lama_usaha', '$jml_unit_usaha', '$total_modal', '$perkembangan_modal', '$selisih_modal', '$klasifikasi')";

	$hasil = $conn->query($query);

	if ($hasil) {
	  return true;
	} else {
	  return false;
	}
}


function ambildataBerdasarkanId(int $id) {
	global $conn;

	$query = "SELECT * FROM `dataset` WHERE id=$id";
	$hasil = $conn->query($query);

	if ($hasil->num_rows > 0) {
		return $hasil->fetch_assoc();
	}

	return null;
}

function editDataBerdasarkanId(array $dataBaru) {
	global $conn;

	$id = htmlspecialchars(($dataBaru["id"]));
	$kecamatan = htmlspecialchars($dataBaru["kecamatan"]);
	$desa = htmlspecialchars($dataBaru["desa"]);
	$nama_bumdes = htmlspecialchars($dataBaru["nama_bumdes"]);
	$status_badan_hukum = htmlspecialchars($dataBaru["status_badan_hukum"]);
	$lama_usaha = htmlspecialchars($dataBaru["lama_usaha"]);
	$jml_unit_usaha = htmlspecialchars($dataBaru["jml_unit_usaha"]);
	$total_modal = htmlspecialchars($dataBaru["total_modal"]);
	$perkembangan_modal = htmlspecialchars($dataBaru["perkembangan_modal"]);
	$selisih_modal = htmlspecialchars($dataBaru["selisih_modal"]);
	$klasifikasi = htmlspecialchars($dataBaru["klasifikasi"]);
	

	$query = "UPDATE `dataset` SET `kecamatan`='$kecamatan', `desa`='$desa', `nama_bumdes`='$nama_bumdes', status_badan_hukum='$status_badan_hukum', lama_usaha='$lama_usaha', jml_unit_usaha='$jml_unit_usaha', total_modal='$total_modal', perkembangan_modal='$perkembangan_modal', selisih_modal='$selisih_modal', klasifikasi='$klasifikasi' WHERE id=$id";

	$hasil = $conn->query($query);

	if ($hasil) {
		return true;
	}

	return false;
}


function hapusDataBerdasarkanId(int $id) {
	global $conn;

	$query = "DELETE FROM `dataset` WHERE id=$id";
	$hasil = $conn->query($query);

	if ($hasil) {
		return true;
	}

	return false;
}



/*
 * TABEL HASIL HITUNG
 */
function ambilSemuaDataHasilHitung() {
	global $conn;

	$data = [];
	$query = "SELECT * FROM `hasil_hitung`";
	$hasil = $conn->query($query);

	if ($hasil->num_rows > 0) {
		while ($barisData = $hasil->fetch_assoc()) {
			$data[] = $barisData;
		}
	}

	return $data;
}

function simpanDataHasilHitung(array $dataYangDiuji, string $klasifikasi, float $jarakHasil, int $nilaiK) {
	global $conn;

	$kecamatan = $dataYangDiuji["kecamatan"];
	$desa = $dataYangDiuji["desa"];
	$nama_bumdes = $dataYangDiuji["nama_bumdes"];
	$status_badan_hukum = $dataYangDiuji["status_badan_hukum"];
	$lama_usaha = $dataYangDiuji["lama_usaha"];
	$jml_unit_usaha = $dataYangDiuji["jml_unit_usaha"];
	$total_modal = $dataYangDiuji["total_modal"];
	$perkembangan_modal = $dataYangDiuji["perkembangan_modal"];
	$selisih_modal = $dataYangDiuji["selisih_modal"];
	$klasifikasi = $klasifikasi;
	$jarak_hasil = $jarakHasil;
	$nilai_k = $nilaiK;

	$query = "INSERT INTO `hasil_hitung` (id, kecamatan, desa, nama_bumdes, status_badan_hukum, lama_usaha, jml_unit_usaha, total_modal, perkembangan_modal, selisih_modal, jarak_hasil, klasifikasi, nilai_k) VALUES (null, '$kecamatan', '$desa', '$nama_bumdes', '$status_badan_hukum', '$lama_usaha', '$jml_unit_usaha', '$total_modal', '$perkembangan_modal', '$selisih_modal', '$jarak_hasil', '$klasifikasi', '$nilai_k')";

	$hasil = $conn->query($query);

	if ($hasil) {
	  return true;
	} else {
	  return false;
	}
}


function hapusDataHasilHitungBerdasarkanId(int $id) {
	global $conn;

	$query = "DELETE FROM `hasil_hitung` WHERE id=$id";
	$hasil = $conn->query($query);

	if ($hasil) {
		return true;
	}

	return false;
}