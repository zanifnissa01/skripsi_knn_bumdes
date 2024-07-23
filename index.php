<?php

require_once __DIR__ . '/app/init.php';

bersihkanHasilHitungDariSession();

$data = ambilSemuaDataset();
$munculkanAlert = false;

if ($data == null || empty($data)) {
	$munculkanAlert = true;
	$n = 0;
} else {
	$n = floor(count($data) / 2);
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
	<style>
	.form-control::placeholder {
		color:darkgray; /* Warna teks placeholder menjadi semi-transparan */
	}
	</style>
	
	<title>Home | Klasifikasi BUMDes Kab.Tulungagung</title>
</head>
<body>
	<nav class="nav mb-4">
		<div class="container">
			<h1>Klasifikasi BUMDes Kab.Tulungagung</h1>			
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
					<h3>Form Hitung Klasifikasi BUMDes Kab.Tulungagung</h3>
				</div>
				<div class="card-body">
					<form action="./app/proses/hitung.php" method="POST">
				   	<div class="form-group mb-3">
						   <label for="kecamatan">Kecamatan</label>
						   <input type="text" name="kecamatan" class="form-control" id="kecamatan" required>
						</div>	
						<div class="form-group mb-3">
						   <label for="desa">Desa</label>
						   <input type="text" name="desa" class="form-control" id="desa" required>
						</div>	
						<div class="form-group mb-3">
						   <label for="nama_bumdes">Nama BUMDes</label>
						   <input type="text" name="nama_bumdes" class="form-control" id="nama_bumdes" required>
						</div>					
						<div class="row row-cols-3">
							<div class="form-group">
							   <label for="status_badan_hukum">Status Badan Hukum</label>
							   <select name="status_badan_hukum" id="status_badan_hukum" class="form-control" required>
							   	<option value="0">Pendaftaran Badan Hukum</option>
							   	<option value="1">Nama Terverifikasi</option>
								<option value="2">Perbaikan Badan Hukum</option>
							   	<option value="3">Dokumen Badan Hukum Terverifikasi</option>
							   </select>
							</div>
							<div class="form-group">
							   <label for="lama_usaha">Lama Usaha <small>(Tahun)</small></label>
							   <input type="number" min="0" name="lama_usaha" class="form-control" id="lama_usaha" required>
							</div>
							<div class="form-group">
							   <label for="jml_unit_usaha">Jumlah Unit Usaha <small>(Unit)</small></label>
							   <input type="number" step="any" min="0" name="jml_unit_usaha" class="form-control" id="jml_unit_usaha" required>
							</div>
						</div>
						<div class="row row-cols-3">
							<div class="form-group">
							   <label for="total_modal">Total Modal </label>
							   <input type="number" step="any" min="0" name="total_modal" class="form-control" id="total_modal" required>
							</div>
							<div class="form-group">
							   <label for="perkembangan_modal">Perkembangan Modal </label>
							   <input type="number" step="any" min="0" name="15.000.000" class="form-control" id="perkembangan_modal" required>
							</div>
						</div>
						<div class="form-group">
							   <label for="selisih_modal">Selisih Modal </label>
							   <input type="number" step="any" min="0" name="selisih_modal" class="form-control" id="selisih_modal" required>
							</div>
						</div>
						<div class="row row-cols-2">
							<div class="form-group">
							   <label for="tetanggaTerdekat">Tetangga Terdekat:</label>
							   <input type="number" min="0" name="tetangga_terdekat" class="form-control" placeholder="2" id="tetanggaTerdekat" required>
							   <small id="passwordHelpBlock" class="form-text text-muted">
								  Disarankan untuk tidak melebihi setengah dari total dataset (yaitu <?= $n; ?>) dan sebaiknya ganjil.
								</small>
							</div>
						</div>
						<button type="submit" class="btn btn-primary cta">Hitung</button>
					</form>
				</div>
			</div>
		</div>	
	</div>

	<?php if ($munculkanAlert) : ?>
		<script>alert("Tidak ada dataset!")</script>
	<?php endif; ?>

</body>
</html>