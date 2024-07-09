<?php 

require_once __DIR__ . '/app/init.php';

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
	
	<title>Import Dataset | Klasifikasi BUMDes Kab.Tulungagung</title>
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
		</div>

		<div class="container-fluid my-4">
			<div class="card">
				<div class="card-title">
					<h3>Import Dataset</h3>
				</div>
				<div class="card-body">
					<h4 class="my-2"><b>NB: Isi file (xls/xlsx) harus mengikuti format berikut!</b></h4>

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
								<th class="text-center">Klasifikasi</th>
							</tr>   
						 </thead>
						<tbody>
							<tr>
								<td align="center">1</td>
								<td>Contoh Kecamatan</td>
								<td>Contoh Desa</td>
								<td>Contoh Nama BUMDes</td>
								<td align="center">1</td>
								<td align="center">7</td>
								<td align="center">7</td>
								<td align="center">15000000</td>
								<td align="center">16926588</td>
								<td align="center">1926588</td>
								<td align="center">Berkembang</td>
							</tr>
							<tr>
								<td align="center">2</td>
								<td>Contoh Kecamatan 2</td>
								<td>Contoh Desa 2</td>
								<td>Contoh Nama BUMDes 2</td>
								<td align="center">3</td>
								<td align="center">4</td>
								<td align="center">1</td>
								<td align="center">183633750</td>
								<td align="center">257003350</td>
								<td align="center">73369600</td>
								<td align="center">Maju</td>
							</tr>
							<tr>
								<td align="center">...</td>
								<td align="center">...</td>
								<td align="center">...</td>
								<td align="center">...</td>
								<td align="center">...</td>
								<td align="center">...</td>
								<td align="center">...</td>
								<td align="center">...</td>
							</tr>
						</tbody>
					</table>

					<form action="./app/proses/import.php" method="POST" enctype="multipart/form-data" class="mt-2">
						<div class="row row-cols-3">
							<div class="form-group mb-3">
								<label for="file_dataset">Upload File Excel</label>
								<input type="file" name="file_dataset" id="file_dataset" required />
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Import</button>
						<a href="dataset.php"><button type="button" class="btn btn-secondary">Kembali</button></a>
					</form>
				</div>
			</div>
		</div>	
	</div>

</body>
</html>