<?php

function dataFormLengkap(array $data, string $formAsal) {
	$requiredFields = [];

	switch ($formAsal) {
			case 'formHitungKlasifikasi':
					$requiredFields = [
							'kecamatan',
							'desa',
							'nama_bumdes',
							'status_badan_hukum',
							'lama_usaha',
							'jml_unit_usaha',
							'total_modal',
							'perkembangan_modal',
							'selisih_modal',
							'tetangga_terdekat'
					];
					break;
			case 'formEditDataset':
					$requiredFields = [
							'kecamatan',
							'desa',
							'nama_bumdes',
							'status_badan_hukum',
							'lama_usaha',
							'jml_unit_usaha',
							'total_modal',
							'perkembangan_modal',
							'selisih_modal',
							'klasifikasi',
							'id'
					];
					break;
			case 'formTambahDataset':
					$requiredFields = [
							'kecamatan',
							'desa',
							'nama_bumdes',
							'status_badan_hukum',
							'lama_usaha',
							'jml_unit_usaha',
							'total_modal',
							'perkembangan_modal',
							'selisih_modal',
							'klasifikasi'
					];
					break;
			case 'formHapusDataset':
					$requiredFields = ['id'];
					break;
			default:
					return false;
	}

	foreach ($requiredFields as $field) {
			if (!isset($data[$field]) || empty($data[$field])) {
					// Optional: Debugging
					// echo "Field missing or empty: $field<br>";
					return false;
			}
	}

	return true;
}
