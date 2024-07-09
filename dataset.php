<?php

require_once __DIR__ . '/app/init.php';

bersihkanHasilHitungDariSession();

$data = ambilSemuaDataset();

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
	
	<title>Dataset | Klasifikasi BUMDes Kab.Tulungagung</title>
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
			<a href="#" class="btn btn-primary-outline btn-sm link" data-toggle="modal" data-target="#modalTambah">Tambah Data</a>
			<a href="import_dataset.php" class="btn btn-primary-outline btn-sm link">Import Dataset</a>
		</div>

		<div class="container-fluid my-4">
			<div class="card">
				<div class="card-title">
					<h3>Tabel Dataset</h3>
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
							<th class="text-center">Jarak Hasil</th>
							<th class="text-center">Nilai K</th>
							<th class="text-center">Klasifikasi</th>
							<th class="text-center">Aksi</th>
					    </tr>
					  </thead>
						<tbody>
						<?php if ( !isset($data) || $data === null || empty($data) ) { ?>
							<tr>
								<th colspan="9" style="padding: 1rem;">Belum ada dataset</th>
							</tr>
						<?php } else { ?>
					  	<?php $i = 1; ?>
					  	<?php foreach ($data as $dt) : ?>
							<?php $selisih = $dt['total_modal'] - $dt['perkembangan_modal']; ?>
					  		<tr>
					  			<td align="center"><?= $i; ?></td>
					  			<td><?= $dt['kecamatan']; ?></td>
								<td><?= $dt['desa']; ?></td>
								<td><?= $dt['nama_bumdes']; ?></td>
								<td><?= $dt['status_badan_hukum'] == "Pendaftaran Badan Hukum" ? 0 : (
											$dt['status_badan_hukum'] == "Nama Terverifikasi" ? 1 : (
												$dt['status_badan_hukum'] == "Perbaikan Dokumen Badan Hukum" ? 2 : (
													$dt['status_badan_hukum'] == "Dokumen Badan Hukum Terverifikasi" ? 3 : "Status Tidak Dikenal"))); ?>
								</td>
					  			<td align="center"><?= $dt['lama_usaha']; ?> Tahun</td>
					  			<td align="center"><?= $dt['jml_unit_usaha']; ?> Unit</td>
					  			<td align="center"><?= $dt['total_modal']; ?> </td>
					  			<td align="center"><?= $dt['perkembangan_modal']; ?> </td>
								<!-- ini td diedit blm ditest boszzz -->
								<td align="center"><?= $selisih ?> </td>
					  			<td align="center"><?= $dt['jarak_hasil']; ?></td>
					  			<td align="center"><?= $dt['nilai_k']; ?></td>
					  			<?php if ($dt['klasifikasi'] == 'pemula') { ?>
					  				<td align="center">
					  					<span class="badge badge-danger"><?= ucfirst($dt['klasifikasi']); ?></span>
					  				</td>
					  			<?php } else if ($dt['klasifikasi'] == 'berkembang') { ?>
					  				<td align="center">
					  					<span class="badge badge-warning"><?= ucfirst($dt['klasifikasi']); ?></span>
				  					</td>
					  			<?php } else if ($dt['klasifikasi'] == 'maju') { ?>
					  				<td align="center">
					  					<span class="badge badge-success"><?= ucfirst($dt['klasifikasi']); ?></span>
				  					</td>
			  					<?php } ?>

			  					 <td align="center" class="nowrap">
							  	 	<a href="./edit_dataset.php?id=<?= $dt['id']; ?>" role="button" class="badge badge-warning">Edit</a>
							  	 	<a href="./app/proses/hapus.php?id=<?= $dt['id']; ?>" role="button" class="badge badge-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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



	<!-- Modal Tambah -->
  	<div class="modal" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Form Tambah Dataset</h5>
	        <div role="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </div>
	      </div>
	      <form action="./app/proses/tambah.php" method="POST">
	      <div class="modal-body">
	      	<div class="form-group mb-3">
				   <label for="nama">Nama</label>
				   <input type="text" class="form-control" placeholder="Rully Ihza Mahendra" id="nama" name="nama" required>
				</div>					
				<div class="row row-cols-3">
					<div class="form-group">
					   <label for="jenisKelamin">Jenis Kelamin</label>
					   <select name="jenis_kelamin" id="jenisKelamin" class="form-control" required>
					   	<option value="1">Laki-laki</option>
					   	<option value="2">Perempuan</option>
					   </select>
					</div>
					<div class="form-group">
					   <label for="umur">Umur <small>(Tahun)</small></label>
					   <input type="number" min="0" name="umur" class="form-control" id="umur" required>
					</div>
					<div class="form-group">
					   <label for="beratBadan">Berat Badan <small>(Kg)</small></label>
					   <input type="number" step="any" min="0" name="berat_badan" class="form-control" id="beratBadan" required>
					</div>
				</div>
				<div class="row row-cols-3">
					<div class="form-group">
					   <label for="tinggiBadan">Tinggi Badan <small>(Cm)</small></label>
					   <input type="number" step="any" min="0" name="tinggi_badan" class="form-control" id="tinggiBadan" required>
					</div>
					<div class="form-group">
					   <label for="lingkarKepala">Lingkar Kepala <small>(Cm)</small></label>
					   <input type="number" step="any" min="0" name="lingkar_kepala" class="form-control" id="lingkarKepala" required>
					</div>
					<div class="form-group">
					   <label for="klasifikasi">Klasifikasi</label>
					   <select name="klasifikasi" id="klasifikasi" class="form-control" required>
					   	<option value="lebih">Lebih</option>
					   	<option value="baik">Baik</option>
					   	<option value="kurang">Kurang</option>
					   	<option value="buruk">Buruk</option>
					   </select>
					</div>
				</div>
	      </div>
	      <div class="modal-footer">
	      	<button type="submit" class="btn btn-primary">Tambah</button>
	      	<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	      </div>
	      </form>
	  </div>
	</div>



	<script src="./public/js/app.js"></script>
</body>
</html>