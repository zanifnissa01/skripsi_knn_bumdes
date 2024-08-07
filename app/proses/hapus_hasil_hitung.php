<?php
require_once __DIR__ . '/../init.php';

if (isset($_GET["id"])) {
    if (hapusDataHasilHitungBerdasarkanId(intval($_GET["id"]))) {
        // Berhasil menghapus data
        echo "<script>alert('Berhasil menghapus data!');</script>";
        // Redirect ke halaman data_hasil_hitung.php
        header("Location: /data_hasil_hitung.php");
        exit();
    } else {
        // Gagal menghapus data
        echo "<script>alert('Gagal menghapus data!');</script>";
        // Redirect ke halaman data_hasil_hitung.php
        header("Location: /data_hasil_hitung.php");
        exit();
    }
} else {
    // Aksi tidak diizinkan (ID tidak ada)
    echo "<script>alert('Maaf, aktivitas ini tidak diizinkan!');</script>";
    // Redirect ke halaman index.php
    header("Location: /index.php");
    exit();
}
