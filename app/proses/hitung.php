<?php

require_once __DIR__ . '/../init.php';

use \Rllyhz\Dev\KNN\Schema;
use \Rllyhz\Dev\KNN\DataSet;
use \Rllyhz\Dev\KNN\Data;

if (dataFormLengkap($_POST, 'formHitungKlasifikasi')) {

	$k = intval($_POST["tetangga_terdekat"]);

	$dataUntukDihitung = [
		"kecamatan" =>  $_POST["kecamatan"],
		"desa" =>  $_POST["desa"],
		"nama_bumdes" =>  $_POST["nama_bumdes"],
		"status_badan_hukum" =>  intval($_POST["status_badan_hukum"]),
		"lama_usaha" =>  intval($_POST["lama_usaha"]),
		"jml_unit_usaha" =>  intval($_POST["jml_unit_usaha"]),
		"total_modal" =>  doubleval($_POST["total_modal"]),
		"perkembangan_modal" =>  doubleval($_POST["perkembangan_modal"]),
		"selisih_modal" =>  doubleval($_POST["selisih_modal"]),
	];

	$semuaData = ambilSemuaDataset();

	$schema = new Schema();
	$schema
		->tambahParameter('status_badan_hukum')
		->tambahParameter('lama_usaha')
		->tambahParameter('jml_unit_usaha')
		->tambahParameter('total_modal')
		->tambahParameter('perkembangan_modal')
		->tambahParameter('selisih_modal')
		->setParameterKlasifikasi('klasifikasi');

	$dataset = new DataSet($schema, $k);


	foreach ($semuaData as $data) {

		$dataset->tambah(new Data([
			'kecamatan' => $data['kecamatan'],
			'desa' => $data['desa'],
			'nama_bumdes' => $data['nama_bumdes'],
			'status_badan_hukum' => intval($data['status_badan_hukum']),
			'lama_usaha' => intval($data['lama_usaha']),
			'jml_unit_usaha' => intval($data['jml_unit_usaha']),
			'total_modal' => floatval($data['total_modal']),
			'perkembangan_modal' => floatval($data['perkembangan_modal']),
			'selisih_modal' => floatval($data['selisih_modal']),
			'klasifikasi' => $data['klasifikasi']
		]));

	}

	$hasil = $dataset->hitung(
		new Data([
			'kecamatan' => $dataUntukDihitung["kecamatan"],
			'desa' => $dataUntukDihitung["desa"],
			'nama_bumdes' => $dataUntukDihitung["nama_bumdes"],
			'status_badan_hukum' => $dataUntukDihitung["status_badan_hukum"],
			'lama_usaha' => $dataUntukDihitung["lama_usaha"],
			'jml_unit_usaha' => $dataUntukDihitung["jml_unit_usaha"],
			'total_modal' => $dataUntukDihitung["total_modal"],
			'perkembangan_modal' => $dataUntukDihitung["perkembangan_modal"],
			'selisih_modal' => $dataUntukDihitung["selisih_modal"]
		])
	);

	$hasilHitung = $hasil["hasil_hitung"];
	$tetanggaTerdekat = $hasil["tetangga_terdekat"];
	$dataHasilHitungYangTerurut = $hasil["data_hasil_hitung_yang_terurut"];

	simpanHasilHitungKedalamSession($dataUntukDihitung, $k, $dataHasilHitungYangTerurut, $hasilHitung);

	echo "<script>
			const getUrl = window.location;
			const baseUrl = getUrl .protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
			window.location.href = baseUrl + '/hasil_hitung.php';
		</script>";
	return;

} else {
	echo "<script>
			alert('Maaf, aktivitas ini tidak diizinkan!')
			const getUrl = window.location;
			const baseUrl = getUrl .protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
			window.location.href = baseUrl + '/index.php';
		</script>";
	return;
}

