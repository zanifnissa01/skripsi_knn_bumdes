<?php

require_once __DIR__ . '/../init.php';
require_once __DIR__ . '../../helpers/database.php';

if (adaHasilHitung()) {
    $data = ambilSemuaHasilDariSession();
    $dataYangDiuji = $data["data_yang_diuji"];
    $nilaiK = $data["nilai_k"];
    $klasifikasi = $data["klasifikasi_yang_terpilih"];

    // Bersihkan sesi hasil hitung
    bersihkanHasilHitungDariSession();

    // Simpan data hasil hitung ke database
    if (simpanDataHasilHitung($dataYangDiuji, $klasifikasi, $nilaiK)) {
        // Redirect ke halaman data_hasil_hitung.php setelah berhasil menyimpan data
        header('Location: /data_hasil_hitung.php');
        exit();
    } else {
        // Redirect ke halaman index.php jika gagal menyimpan data
        header('Location: /index.php');
        exit();
    }
} else {
    // Redirect ke halaman index.php jika tidak ada hasil hitung
    header('Location: /index.php');
    exit();
}
