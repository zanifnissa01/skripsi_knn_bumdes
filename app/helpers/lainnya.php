<?php

function dataFormLengkap(array $data, string $formAsal) {
	if ($formAsal === 'formHitungKlasifikasi') {

		if ( isset($data["kecamatan"]) && isset($data["desa"]) && isset($data["nama_bumdes"]) && isset($data["status_badan_hukum"]) && isset($data["lama_usaha"]) && isset($data["jml_unit_usaha"]) && isset($data["total_modal"]) && isset($data["perkembangan_modal"]) && isset($data["selisih_modal"]) && isset($data["tetangga_terdekat"]) )
		{
			return true;
		} 

	}

	if ($formAsal === 'formEditDataset') {

		if ( isset($data["kecamatan"]) && isset($data["desa"]) && isset($data["nama_bumdes"]) && isset($data["status_badan_hukum"]) && isset($data["lama_usaha"]) && isset($data["jml_unit_usaha"]) && isset($data["total_modal"]) && isset($data["perkembangan_modal"]) && isset($data["selisih_modal"]) && isset($data["klasifikasi"]) && isset($data["id"]) )
		{
			return true;
		} 

	}

	if ($formAsal === 'formTambahDataset') {

		if ( isset($data["kecamatan"]) && isset($data["desa"]) && isset($data["nama_bumdes"]) && isset($data["status_badan_hukum"]) && isset($data["lama_usaha"]) && isset($data["jml_unit_usaha"]) && isset($data["total_modal"]) && isset($data["perkembangan_modal"]) && isset($data["selisih_modal"]) && isset($data["klasifikasi"]) )
		{
			return true;
		} 

	}

	if ($formAsal === 'formHapusDataset') {

		if ( isset($data["id"]) )
		{
			return true;
		} 

	}

	return false;
}
