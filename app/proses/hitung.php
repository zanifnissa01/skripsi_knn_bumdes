<?php
require_once __DIR__ . '/../init.php';
require_once __DIR__ . '../../helpers/database.php';

// Mulai output buffering untuk menghindari "headers already sent" error
ob_start();

try {
    // Ambil data dari form
    $kecamatan = $_POST['kecamatan'];
    $desa = $_POST['desa'];
    $nama_bumdes = $_POST['nama_bumdes'];
    $status_badan_hukum = intval($_POST['status_badan_hukum']);
    $lama_usaha = intval($_POST['lama_usaha']);
    $jml_unit_usaha = intval($_POST['jml_unit_usaha']);
    $total_modal = floatval($_POST['total_modal']); // Menggunakan floatval untuk keakuratan
    $perkembangan_modal = floatval($_POST['perkembangan_modal']); // Menggunakan floatval untuk keakuratan

    // Perhitungan selisih modal
    $selisih_modal = $total_modal - $perkembangan_modal;

    $selisih_modal = abs($selisih_modal);

    // Debug output untuk memastikan nilai sudah benar sebelum disimpan
    echo "Total Modal: $total_modal, Perkembangan Modal: $perkembangan_modal, Selisih Modal: $selisih_modal";

    // Ambil nilai K dari form
    $nilai_k = intval($_POST['tetangga_terdekat']);

    // Koneksi ke database dan ambil data training
    $conn = koneksiDatabase();
    $result = $conn->query("SELECT * FROM dataset");
    $dataTraining = $result->fetch_all(MYSQLI_ASSOC);

    // Normalisasi data
    function normalisasi($value, $min, $max) {
        return ($max - $min) == 0 ? 0 : ($value - $min) / ($max - $min);
    }

    // Ambil nilai minimum dan maksimum dari data training untuk normalisasi
    $minMax = [
        'lama_usaha' => ['min' => PHP_INT_MAX, 'max' => PHP_INT_MIN],
        'status_badan_hukum' => ['min' => PHP_INT_MAX, 'max' => PHP_INT_MIN],
        'jml_unit_usaha' => ['min' => PHP_INT_MAX, 'max' => PHP_INT_MIN],
        'total_modal' => ['min' => PHP_INT_MAX, 'max' => PHP_INT_MIN],
        'perkembangan_modal' => ['min' => PHP_INT_MAX, 'max' => PHP_INT_MIN],
        'selisih_modal' => ['min' => PHP_INT_MAX, 'max' => PHP_INT_MIN],
    ];

    // Cari nilai min dan max untuk normalisasi
    foreach ($dataTraining as $data) {
        foreach ($minMax as $key => &$minMaxValues) {
            $minMaxValues['min'] = min($minMaxValues['min'], $data[$key]);
            $minMaxValues['max'] = max($minMaxValues['max'], $data[$key]);
        }
    }

    // Normalisasi data uji
    $dataUjiNormal = [
        'lama_usaha' => normalisasi($lama_usaha, $minMax['lama_usaha']['min'], $minMax['lama_usaha']['max']),
        'status_badan_hukum' => normalisasi($status_badan_hukum, $minMax['status_badan_hukum']['min'], $minMax['status_badan_hukum']['max']),
        'jml_unit_usaha' => normalisasi($jml_unit_usaha, $minMax['jml_unit_usaha']['min'], $minMax['jml_unit_usaha']['max']),
        'total_modal' => normalisasi($total_modal, $minMax['total_modal']['min'], $minMax['total_modal']['max']),
        'perkembangan_modal' => normalisasi($perkembangan_modal, $minMax['perkembangan_modal']['min'], $minMax['perkembangan_modal']['max']),
        'selisih_modal' => normalisasi($selisih_modal, $minMax['selisih_modal']['min'], $minMax['selisih_modal']['max']),
    ];

    // Normalisasi data training dan hitung jarak Euclidean
    $dataHasilHitung = [];
    foreach ($dataTraining as $data) {
        $dataTrainingNormal = [
            'lama_usaha' => normalisasi($data['lama_usaha'], $minMax['lama_usaha']['min'], $minMax['lama_usaha']['max']),
            'status_badan_hukum' => normalisasi($data['status_badan_hukum'], $minMax['status_badan_hukum']['min'], $minMax['status_badan_hukum']['max']),
            'jml_unit_usaha' => normalisasi($data['jml_unit_usaha'], $minMax['jml_unit_usaha']['min'], $minMax['jml_unit_usaha']['max']),
            'total_modal' => normalisasi($data['total_modal'], $minMax['total_modal']['min'], $minMax['total_modal']['max']),
            'perkembangan_modal' => normalisasi($data['perkembangan_modal'], $minMax['perkembangan_modal']['min'], $minMax['perkembangan_modal']['max']),
            'selisih_modal' => normalisasi($data['selisih_modal'], $minMax['selisih_modal']['min'], $minMax['selisih_modal']['max']),
        ];

        // Hitung jarak Euclidean
        $jarak = sqrt(
            pow($dataUjiNormal['lama_usaha'] - $dataTrainingNormal['lama_usaha'], 2) +
            pow($dataUjiNormal['status_badan_hukum'] - $dataTrainingNormal['status_badan_hukum'], 2) +
            pow($dataUjiNormal['jml_unit_usaha'] - $dataTrainingNormal['jml_unit_usaha'], 2) +
            pow($dataUjiNormal['total_modal'] - $dataTrainingNormal['total_modal'], 2) +
            pow($dataUjiNormal['perkembangan_modal'] - $dataTrainingNormal['perkembangan_modal'], 2) +
            pow($dataUjiNormal['selisih_modal'] - $dataTrainingNormal['selisih_modal'], 2)
        );

        $dataHasilHitung[] = array_merge($data, ['jarak' => $jarak]);
    }

    // Urutkan hasil berdasarkan jarak terkecil
    usort($dataHasilHitung, function($a, $b) {
        return $a['jarak'] <=> $b['jarak'];
    });

    // Ambil K tetangga terdekat
    $dataTerdekat = array_slice($dataHasilHitung, 0, $nilai_k);

    // Tentukan klasifikasi berdasarkan mayoritas dari K tetangga terdekat
    $klasifikasiCounts = array_count_values(array_column($dataTerdekat, 'klasifikasi'));
    $klasifikasi = array_search(max($klasifikasiCounts), $klasifikasiCounts);

    // Simpan hasil ke sesi
    simpanHasilHitungKedalamSession([
        'kecamatan' => $kecamatan,
        'desa' => $desa,
        'nama_bumdes' => $nama_bumdes,
        'status_badan_hukum' => $status_badan_hukum,
        'lama_usaha' => $lama_usaha,
        'jml_unit_usaha' => $jml_unit_usaha,
        'total_modal' => $total_modal,
        'perkembangan_modal' => $perkembangan_modal,
        'selisih_modal' => $selisih_modal,
    ], $nilai_k, $dataTerdekat, ['klasifikasi' => $klasifikasi]);

    // Redirect ke halaman hasil_hitung.php
    header('Location: /hasil_hitung.php');
    exit();

} catch (Exception $e) {
    // Tangani pengecualian dan tampilkan pesan kesalahan
    echo "<script>
            alert('Terjadi kesalahan: " . $e->getMessage() . "');
            window.location.href = '/index.php';
          </script>";
    exit();
}

// Akhiri output buffering
ob_end_flush();
