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

	<style>
	.form-control::placeholder {
		color:darkgray; /* Warna teks placeholder menjadi semi-transparan */
	}
	</style>
	
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
			<a href="dataset.php" class="btn btn-primary-outline btn-sm link" data-toggle="modal" data-target="#modalTambah">Tambah Data</a>
			<a href="import_dataset.php" class="btn btn-primary-outline btn-sm link">Import Dataset</a>
		</div>

		<div class="container-fluid my-4">
			<div class="card-table">
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
							<!-- <th class="text-center">Jarak Hasil</th>
							<th class="text-center">Nilai K</th> -->
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
							<!-- $selisih = $dt['perkembangan_modal'] - $dt['total_modal']; -->
					  		<tr>
					  			<td align="center"><?= $i; ?></td>

					  			<td><?= $dt['kecamatan']; ?></td>

								<td><?= $dt['desa']; ?></td>

								<td><?= $dt['nama_bumdes']; ?></td>

								<td>
								<?php if ($dt['status_badan_hukum'] == 0) {?>									
									<?= ("Pendaftaran Badan Hukum"); ?>
								
								<?php } else if ($dt['status_badan_hukum'] == 1) { ?>
									<?= ("Nama Terverifikasi"); ?>
								
								<?php } else if ($dt['status_badan_hukum'] == 2) { ?>
									<?= ("Perbaikan Dokumen Badan Hukum"); ?>

								<?php } else if ($dt['status_badan_hukum'] == 3) { ?>
									<?= ("Dokumen Badan Hukum Terverifikasi"); ?>
								<?php } ?>
								</td>

					  			<td align="center"><?= $dt['lama_usaha']; ?> Tahun</td>

					  			<td align="center"><?= $dt['jml_unit_usaha']; ?> Unit</td>

					  			<td align="center"><?= $dt['total_modal']; ?> </td>

					  			<td align="center"><?= $dt['perkembangan_modal']; ?> </td>

								<!-- ini td diedit blm ditest boszzz -->
								<td align="center"><?= $dt['selisih_modal'] ?> </td>

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
				   <label for="kecamatan">Kecamatan</label>
				   <input type="text" class="form-control" placeholder="Boyolangu" id="kecamatan" name="kecamatan" required>
				</div>	
				<div class="form-group mb-3">
				   <label for="desa">Desa</label>
				   <input type="text" class="form-control" placeholder="Wajak Kidul" id="desa" name="desa" required>
				</div>
				<div class="form-group mb-3">
				   <label for="nama_bumdes">Nama BUMDes</label>
				   <input type="text" class="form-control" placeholder="Sinar Harapan" id="nama_bumdes" name="nama_bumdes" required>
				</div>				
				<div class="row row-cols-3">
					<div class="form-group">
					   <label for="status_badan_hukum">Status Badan Hukum</label>
					   <select name="status_badan_hukum" id="status_badan_hukum" class="form-control" required>
					   	<option value="0">Pendaftaran Badan Hukum</option>
					   	<option value="1">Nama Terverifikasi</option>
						<option value="2">Perbaikan Dokumen Badan Hukum</option>
					   	<option value="3">Dokumen Badan Hukum Terverivikasi</option>
					   </select>
					</div>
					<div class="form-group">
					   <label for="lama_usaha">Lama Usaha <small>(Tahun)</small></label>
					   <input type="number" min="0" name="lama_usaha" placeholder="5"  class="form-control" id="lama_usaha" required>
					</div>
					<div class="form-group">
					   <label for="jml_unit_usaha">Jumlah Unit Usaha <small>(Unit)</small></label>
					   <input type="number" step="any" min="0" name="jml_unit_usaha" placeholder="3"  class="form-control" id="jml_unit_usaha" required>
					</div>
				</div>
				<div class="row row-cols-3">
					<div class="form-group">
					   <label for="total_modal">Total Modal </label>
					   <input type="number" step="any" min="0" name="total_modal" placeholder="10.000.000"  class="form-control" id="total_modal" required>
					</div>
					<div class="form-group">
					   <label for="perkembangan_modal">Perkembangan Modal </label>
					   <input type="number" step="any" min="0" name="perkembangan_modal" placeholder="13.000.000"  class="form-control" id="perkembangan_modal" required>
					</div>
					<div class="form-group">
					<div class="form-group">
					   <label for="selisih_modal">Selisih Modal </label>
					   <input type="number" step="any" min="0" name="selisih_modal" placeholder="3.000.000"  class="form-control" id="selisih_modal" required>
					</div>
					<div class="form-group">
					   <label for="klasifikasi">Klasifikasi</label>
					   <select name="klasifikasi" id="klasifikasi" class="form-control" required>
					   	<option value="maju">Maju</option>
					   	<option value="berkembang">Berkembang</option>
					   	<option value="pemula">Pemula</option>
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