<?php
// session.php
// Pastikan session sudah dimulai di tempat lain dalam aplikasi sebelum memanggil fungsi-fungsi ini

function simpanHasilHitungKedalamSession(array $dataUntukDihitung, int $nilaiK, array $dataHasilHitungYangTerurut, array $hasilHitung) {
    $_SESSION["ada_hasil_hitung"] = true;
    $_SESSION["nilai_k"] = $nilaiK;
    $_SESSION["hasil_hitung"] = $dataHasilHitungYangTerurut;
    $_SESSION["data_yang_diuji"] = $dataUntukDihitung;
    $_SESSION["klasifikasi_yang_terpilih"] = $hasilHitung["klasifikasi"];
    $_SESSION["selisih_modal"] = $dataUntukDihitung["selisih_modal"]; // Tambahkan selisih_modal ke session

    // Debug output untuk memastikan data disimpan dengan benar
    echo "<pre>";
    print_r($_SESSION["data_yang_diuji"]); // Pastikan nilai yang disimpan di session benar
    echo "</pre>";
    }

function bersihkanHasilHitungDariSession() {
    $_SESSION["ada_hasil_hitung"] = false;
    $_SESSION["nilai_k"] = null;
    $_SESSION["hasil_hitung"] = [];
    $_SESSION["data_yang_diuji"] = [];
    $_SESSION["klasifikasi_yang_terpilih"] = null;
    $_SESSION["selisih_modal"] = null; // Bersihkan selisih_modal dari session
    return true;
}

function adaHasilHitung() {
    return isset($_SESSION["ada_hasil_hitung"]) && $_SESSION["ada_hasil_hitung"];
}

function ambilSemuaHasilDariSession() {
    return [
        "ada_hasil_hitung" => $_SESSION["ada_hasil_hitung"] ?? false,
        "nilai_k" => $_SESSION["nilai_k"] ?? null,
        "hasil_hitung" => $_SESSION["hasil_hitung"] ?? [],
        "data_yang_diuji" => $_SESSION["data_yang_diuji"] ?? [],
        "klasifikasi_yang_terpilih" => $_SESSION["klasifikasi_yang_terpilih"] ?? null,
    ];
}