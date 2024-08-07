<?php
require_once __DIR__ . '/app/init.php';

// Ambil data dari sesi
$dataHasilHitung = [];
if (adaHasilHitung()) {
    $dataSession = ambilSemuaHasilDariSession();
    $dataHasilHitung = $dataSession["hasil_hitung"];
    $nilaiK = $dataSession["nilai_k"];
    $klasifikasi = $dataSession["klasifikasi_yang_terpilih"];
} else {
    echo "<script>
            alert('Data hasil hitung tidak tersedia!');
            window.location.href = '/index.php';
        </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
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
                        <?php if (empty($dataHasilHitung)) { ?>
                            <tr>
                                <th colspan="12" style="padding: 1rem;">Tidak ada data hasil hitung</th>
                            </tr>
                        <?php } else { ?>
                            <?php $i = 1; ?>
                            <?php foreach ($dataHasilHitung as $data) : ?>
                                <tr>
                                    <td align="center"><?= $i; ?></td>
                                    <td><?= $data['kecamatan']; ?></td>
                                    <td><?= $data['desa']; ?></td>
                                    <td><?= $data['nama_bumdes']; ?></td>
                                    <td align="center">
                                    <?php
                                            $status = $data['status_badan_hukum'];
                                            echo ($status == 0) ? 'Pendaftaran Badan Hukum' :
                                                    (($status == 1) ? 'Nama Terverifikasi' :
                                                    (($status == 2) ? 'Perbaikan Dokumen Badan Hukum' :
                                                    (($status == 3) ? 'Dokumen Badan Hukum Terverifikasi' : 'Status Tidak Dikenal')));
                                    ?>
                                    </td>

                                    <td align="center"><?= $data['lama_usaha']; ?> Tahun</td>
                                    <td align="center"><?= $data['jml_unit_usaha']; ?> Unit</td>
                                    <td align="center"><?= $data['total_modal']; ?></td>
                                    <td align="center"><?= $data['perkembangan_modal']; ?></td>
                                    <td align="center"><?= number_format(abs($data['selisih_modal']), 0, ',', '.'); ?></td>
                                    <td align="center" class="highlight"><?= number_format($data['jarak'], 5, '.', ''); ?></td>
                                    <td align="center">
                                        <?php if ($data['klasifikasi'] == 'pemula') { ?>
                                            <span class="badge badge-danger"><?= ucfirst($data['klasifikasi']); ?></span>
                                        <?php } else if ($data['klasifikasi'] == 'berkembang') { ?>
                                            <span class="badge badge-warning"><?= ucfirst($data['klasifikasi']); ?></span>
                                        <?php } else if ($data['klasifikasi'] == 'maju') { ?>
                                            <span class="badge badge-success"><?= ucfirst($data['klasifikasi']); ?></span>
                                        <?php } ?>
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
