<?php

require_once __DIR__ . '/app/init.php';

bersihkanHasilHitungDariSession();

$data = ambilSemuaDataHasilHitung();

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

	<title>Data Hasil Hitung | Klasifikasi BUMDes Kab.Tulungagung</title>
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
			<a href="data_hasil_hitung.php" class="btn btn-secondary-outline btn-sm link" style="margin-right: 20px;">Data Hasil Hitung</a>
		</div>

		<div class="container-fluid my-4">
			<div class="card-table">
				<div class="card-title">
					<h3>Tabel Data Hasil Hitung</h3>
				</div>
				<div class="card-body mt-3">
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
					      <th class="text-center">Nilai K</th>
					      <th class="text-center">Klasifikasi</th>
					      <th class="text-center">Aksi</th>
					    </tr>
					  </thead>
						<tbody>
						<?php if ( !isset($data) || $data === null || empty($data) ) { ?>
							<tr>
								<th colspan="13" style="padding: 1rem;">Belum ada data hitung</th>
							</tr>
						<?php } else { ?>
					  	<?php $i = 1; ?>

					  	<?php foreach ($data as $dt) : ?>
					  		<tr>
					  			<td align="center"><?= $i; ?></td>
					  			<td><?= htmlspecialchars($dt['kecamatan']); ?></td>
								<td><?= htmlspecialchars($dt['desa']); ?></td>
								<td><?= htmlspecialchars($dt['nama_bumdes']); ?></td>
								<td align="center">
									<?= htmlspecialchars(
										$dt['status_badan_hukum'] == 0 ? "Pendaftaran Badan Hukum" :
										($dt['status_badan_hukum'] == 1 ? "Nama Terverifikasi" :
										($dt['status_badan_hukum'] == 2 ? "Perbaikan Dokumen Badan Hukum" :
										($dt['status_badan_hukum'] == 3 ? "Dokumen Badan Hukum Terverifikasi" : "Status Tidak Dikenal")))); ?>
								</td>
					  			<td align="center"><?= htmlspecialchars($dt['lama_usaha']); ?> Tahun</td>
					  			<td align="center"><?= htmlspecialchars($dt['jml_unit_usaha']); ?> Unit</td>
					  			<td align="center"><?= htmlspecialchars($dt['total_modal']); ?></td>
					  			<td align="center"><?= htmlspecialchars($dt['perkembangan_modal']); ?></td>
								<td align="center"><?=   (htmlspecialchars($dt['selisih_modal'])); ?></td>
					  			<td align="center"><?= htmlspecialchars($dt['nilai_k']); ?></td>
					  			<?php if ($dt['klasifikasi'] == 'pemula') { ?>
					  				<td align="center">
					  					<span class="badge badge-danger"><?= ucfirst(htmlspecialchars($dt['klasifikasi'])); ?></span>
					  				</td>
					  			<?php } else if ($dt['klasifikasi'] == 'berkembang') { ?>
					  				<td align="center">
					  					<span class="badge badge-warning"><?= ucfirst(htmlspecialchars($dt['klasifikasi'])); ?></span>
				  					</td>
					  			<?php } else if ($dt['klasifikasi'] == 'maju') { ?>
					  				<td align="center">
					  					<span class="badge badge-success"><?= ucfirst(htmlspecialchars($dt['klasifikasi'])); ?></span>
				  					</td>
			  					<?php } ?>

			  					 <td align="center" class="nowrap">
							  	 	<a href="./app/proses/hapus_hasil_hitung.php?id=<?= $dt['id']; ?>" role="button" class="badge badge-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
							  	 </td>
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
