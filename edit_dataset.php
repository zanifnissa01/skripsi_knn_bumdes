<?php 

require_once __DIR__ . '/app/init.php';

if (isset($_GET["id"])) {

	$data = ambilDataBerdasarkanId($_GET["id"]);

} else {

	echo "<script>
			alert('Maaf, aktivitas ini tidak diizinkan!')
			const getUrl = window.location;
			const baseUrl = getUrl .protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
			window.location.href = baseUrl + '/dataset.php';
		</script>";

	die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- FONTS -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
	<!-- FONT AWESOME ICON -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="./public/css/style.css">
	<link rel="stylesheet" href="./public/css/app.css">
	
	<title>Edit Dataset | Klasifikasi BUMDes Kab.Tulungagung</title>
</head>
<body>
	<nav class="nav mb-4">
		<div class="container">
			<h1>Klasifikasi BUMDes Kab.Tulungagaung</h1>
		</div>
	</nav>

	<div class="container">

		<div class="button-group">
			<a href="index.php" class="btn btn-secondary-outline btn-sm link">Home</a>
			<a href="dataset.php" class="btn btn-secondary-outline btn-sm link">Dataset</a>
			<a href="data_hasil_hitung.php" class="btn btn-secondary-outline btn-sm link">Data Hasil Hitung</a>
		</div>

		<div class="container-fluid my-4">
			<div class="card">
				<div class="card-title">
					<h3>Form Edit Dataset</h3>
				</div>
				<div class="card-body">
					<form action="./app/proses/edit.php" method="POST">
						<input type="number" hidden name="id" value="<?= $data['id']; ?>" required>
						<div class="form-group mb-3">
								<label for="nama">Kecamatan</label>
								<input type="text" class="form-control" placeholder="Boyolangu" id="kecamatan" name="kecamatan" value="<?= $data['kecamatan']; ?>" required>
							</div>
							<div class="form-group mb-3">
								<label for="nama">Desa</label>
								<input type="text" class="form-control" placeholder="Wajak Kidul" id="desa" name="desa" value="<?= $data['desa']; ?>" required>
							</div>
							<div class="form-group mb-3">
								<label for="nama">Nama BUMDes</label>
								<input type="text" class="form-control" placeholder="Larasati" id="nama_bumdes" name="nama_bumdes" value="<?= $data['nama_bumdes']; ?>" required>
							</div>					
						<div class="row row-cols-3">
							<div class="form-group">
							   <label for="status_badan_hukum">Status Badan Hukum</label>
							   <select name="status_badan_hukum" id="status_badan_hukum" class="form-control" required>
						   		<option <?= $data["status_badan_hukum"] == "0" ? 'selected' : ''; ?> value="0">Pendaftaran Badan Hukum</option>
						   		<option <?= $data["status_badan_hukum"] == "1" ? 'selected' : ''; ?> value="1">Nama Terverifikasi</option>
								<option <?= $data["status_badan_hukum"] == "2" ? 'selected' : ''; ?> value="2">Perbaikan Dokumen Badan Hukum</option>
								<option <?= $data["status_badan_hukum"] == "3" ? 'selected' : ''; ?> value="3">Dokumen Badan Hukum Terverifikasi</option>
							   </select>
							</div>
							<div class="form-group">
							   <label for="lama_usaha">Lama Usaha <small>(Tahun)</small></label>
							   <input type="number" min="0" name="lama_usaha" class="form-control" id="lama_usaha" value="<?= $data['lama_usaha']; ?>" required>
							</div>
							<div class="form-group">
							   <label for="jml_unit_usaha">Jumlah Unit Usaha <small>(Unit)</small></label>
							   <input type="number" step="any" min="0" name="jml_unit_usaha" class="form-control" id="jml_unit_usaha" value="<?= $data['jml_unit_usaha']; ?>" required>
							</div>
						</div>
						<div class="row row-cols-3">
							<div class="form-group">
							   <label for="total_modal">Total Modal </label>
							   <input type="number" step="any" min="0" name="total_modal" class="form-control" id="total_modal" value="<?= $data['total_modal']; ?>" required>
							</div>
							<div class="form-group">
							   <label for="perkembangan_modal">Perkembangan Modal </label>
							   <input type="number" step="any" min="0" name="perkembangan_modal" class="form-control" id="perkembangan_modal" value="<?= $data['perkembangan_modal']; ?>" required>
							</div>
							<div class="form-group">
							   <label for="selisih_modal">Selisih Modal </label>
							   <input type="number" step="any" min="0" name="selisih_modal" class="form-control" id="selisih_modal" value="<?= $data['selisih_modal']; ?>" required>
							</div>
							<div class="form-group">
						   <label for="klasifikasi">Klasifikasi</label>
						   <select name="klasifikasi" id="klasifikasi" class="form-control" required>
					   		<option <?= $data["klasifikasi"] == "maju" ? "selected" : ""; ?> value="maju">Maju</option>
					   		<option <?= $data["klasifikasi"] == "berkembang" ? "selected" : ""; ?> value="berkembang">Berkembang</option>
						   	<option <?= $data["klasifikasi"] == "pemula" ? "selected" : ""; ?> value="pemula">Pemula</option>
						   </select>
						</div>
						</div>
						<button type="submit" class="btn btn-primary cta">Ubah</button>
						<a href="./dataset.php"><button type="button" class="btn btn-secondary cta">Kembali</button></a>
					</form>
				</div>
			</div>
		</div>	
	</div>

</body>
</html>