<?php

require_once __DIR__ . '/app/init.php';

session_start();

$dataHasilHitung = [];

if ( adaHasilHitung() ) {

	$dataSession = ambilSemuaHasilDariSession();
	$dataHasilHitung = $dataSession["hasil_hitung"];
	$nilaiK = $dataSession["nilai_k"];
	$klasifikasi = $dataSession["klasifikasi_yang_terpilih"];

} else {

	echo "<script>
			alert('Maaf, aktivitas ini tidak diizinkan!')
			const getUrl = window.location;
			const baseUrl = getUrl .protocol + '//' + getUrl.host;
			window.location.href = baseUrl + '/index.php';
		</script>";

}

?>



<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- FONTS -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
	<!-- FONT AWESOME ICON -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="./public/css/style.css">
	<link rel="stylesheet" href="./public/css/app.css">
	
	<title>Hasil Hitung | Klasifikasi BUMDes Kab.Tulungagung</title>
</head>
<body>

	<nav class="nav mb-4">
		<div class="container">
			<h1>Klasifikasi BUMDes Kab.Tulungagung</h1>
		</div>
	</nav>
	
	<div class="container">
		
		<div class="button-group">
			<a href="index.php" class="btn btn-secondary-outline btn-sm link" onclick="return confirm('Data hasil hitung akan dihapus?')">Home</a>
			<a href="dataset.php" class="btn btn-secondary-outline btn-sm link" style="margin-right: 20px;" onclick="return confirm('Data hasil hitung akan dihapus?')">Dataset</a>
			<a href="./app/proses/simpan_hasil_hitung.php" class="btn btn-primary btn-sm link" style="margin-right: 20px;">Simpan Hasil</a>
		</div>

		<div class="container-fluid my-4">
			<div class="card">
				<div class="card-title">
					<h3>Hasil Perhitungan Klasifikasi BUMDes Kab.Tulungagung</h3>
				</div>
				<div class="card-body mt-3">
					
					<!-- KESIMPULAN -->
					<div class="row row-cols-3 mt-1 mb-3">
						<div class="row"></div>
						<div class="card">
							<div class="card-title">
								<h3>Kesimpulan</h3>
							</div>
							<div class="card-body">
								<div class="flex align-center mb-1">
									<p class="mr-1">Nilai K :</p>
									<span class="badge badge-primary"><?= $nilaiK; ?></span>
								</div>
								<div class="flex align-center">
									<p class="mr-1">Klasifikasi :</p>
									<?php if ($klasifikasi == 'pemula') { ?>
					  					<span class="badge badge-danger"><?= ucfirst($klasifikasi); ?></span>
					  			<?php } else if ($klasifikasi == 'berkembang') { ?>
					  					<span class="badge badge-warning"><?= ucfirst($klasifikasi); ?></span>
					  			<?php } else if ($klasifikasi == 'maju') { ?>
					  					<span class="badge badge-success"><?= ucfirst($klasifikasi); ?></span>
			  					<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<!-- AKHIR KESIMPULAN -->

					<h4 class="my-2"><b><?= $nilaiK; ?> Tetangga Terdekat : </b></h4>

					<table class="table">
						<thead class="thead-light">
					    <tr>
							<th class="text-center">No</th>
							<th class="text-center">Kecamatan</th>
							<th class="text-center">Desa</th>
							<th class="text-center">Nama BUMDes</th>
							<th class="text-center">Status Badan Hukum</th>
							<th class="text-center">Lama Usaha</th>
							<th class="text-center">Jumlah Unit Usaha</th>
							<th class="text-center">Total Modal</th>
							<th class="text-center">Perkembangan Modal</th>
							<th class="text-center">Selisih Modal</th>
							<th class="text-center">Jarak Hasil</th>
							<th class="text-center">Klasifikasi</th>
					    </tr>
					  	</thead>
						<tbody>
						<?php if ( !isset($dataHasilHitung) || $dataHasilHitung === null || empty($dataHasilHitung) ) { ?>
							<tr>
								<th colspan="9" style="padding: 1rem;">Tidak ada data hasil hitung</th>
							</tr>
						<?php } else { ?>
					  	<?php $i = 1; ?>
					  	<?php foreach ($dataHasilHitung as $data) : ?>
					  	<?php if ($i > $nilaiK) { return; } ?>

					  	<?php $jarakHasilYangTerformat = number_format($data->getJarakHasil(), 5, '.', ''); ?>
					  		<!-- rencana selisihnya pake ini boszz -->
							<?php $selisih = $data->get('total_modal') - $data->get('perkembangan_modal'); ?>
							<tr>
					  			<td align="center"><?= $i; ?></td>
					  			<td><?= $data->get('kecamatan'); ?></td>
								<td><?= $data->get('desa'); ?></td>
								<td><?= $data->get('nama_bumdes'); ?></td>
								<td><?= $data->get['status_badan_hukum'] == "Pendaftaran Badan Hukum" ? 0 : (
											$data->get['status_badan_hukum'] == "Nama Terverifikasi" ? 1 : (
												$data->get['status_badan_hukum'] == "Perbaikan Dokumen Badan Hukum" ? 2 : (
													$data->get['status_badan_hukum'] == "Dokumen Badan Hukum Terverifikasi" ? 3 : "Status Tidak Dikenal"))); ?>
								</td>
					  			<td align="center"><?= $data->get('lama_usaha'); ?> Tahun</td>
					  			<td align="center"><?= $data->get('jml_unit_usaha'); ?> Unit</td>
					  			<td align="center"><?= $data->get('total_modal'); ?> </td>
					  			<td align="center"><?= $data->get('perkembangan_modal'); ?> </td>
								<td align="center"><?= $data->get('selisih_modal'); ?> </td>
					  			<td align="center" class="highlight"><?= $jarakHasilYangTerformat; ?></td>
					  			<?php if ($data->get('klasifikasi') == 'pemula') { ?>
					  				<td align="center">
					  					<span class="badge badge-danger"><?= ucfirst($data->get('klasifikasi')); ?></span>
					  				</td>
					  			<?php } else if ($data->get('klasifikasi') == 'berkembang') { ?>
					  				<td align="center">
					  					<span class="badge badge-warning"><?= ucfirst($data->get('klasifikasi')); ?></span>
				  					</td>
					  			<?php } else if ($data->get('klasifikasi') == 'maju') { ?>
					  				<td align="center">
					  					<span class="badge badge-success"><?= ucfirst($data->get('klasifikasi')); ?></span>
				  					</td>
			  					<?php } ?>

					  		</tr>
					  	 <?php $i++; ?>
					  	 <?php endforeach; ?>
					  	 <?php } ?>
					  </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>



	<script src="./public/js/app.js"></script>
</body>
</html>
<!-- AKHIR HTML -->