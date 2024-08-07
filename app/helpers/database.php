<?php

// Mendefinisikan konstanta koneksi database
define('DB_HOST', $_ENV["DB_HOST"]);
define('DB_NAME', $_ENV["DB_NAME"]);
define('DB_USER', $_ENV["DB_USER"]);
define('DB_PASS', $_ENV["DB_PASS"]);

function koneksiDatabase() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Fungsi untuk menambah data
function tambahData($data, $namaTabel) {
    $conn = koneksiDatabase();
    $query = "INSERT INTO `".$namaTabel."` (
        kecamatan,
        desa,
        nama_bumdes,
        status_badan_hukum,
        lama_usaha,
        jml_unit_usaha,
        total_modal,
        perkembangan_modal,
        selisih_modal,
        klasifikasi)
        VALUES (
        '".$data[0]."',
        '".$data[1]."',
        '".$data[2]."',
        '".$data[3]."',
        '".$data[4]."',
        '".$data[5]."',
        '".$data[6]."',
        '".$data[7]."',
        '".$data[8]."',
        '".$data[9]."')";
    return $conn->query($query) === TRUE ? true : $conn->error;
}

// Fungsi untuk mengambil semua dataset
function ambilSemuaDataset() {
    $conn = koneksiDatabase();
    $data = [];
    $query = "SELECT * FROM `dataset`";
    $hasil = $conn->query($query);
    if ($hasil->num_rows > 0) {
        while ($barisData = $hasil->fetch_assoc()) {
            $data[] = $barisData;
        }
    }
    return $data;
}

// Fungsi untuk menambah dataset
function tambahDataset($dataPost) {
    $conn = koneksiDatabase();
    $kecamatan = htmlspecialchars($dataPost["kecamatan"]);
    $desa = htmlspecialchars($dataPost["desa"]);
    $nama_bumdes = htmlspecialchars($dataPost["nama_bumdes"]);
    $status_badan_hukum = htmlspecialchars($dataPost["status_badan_hukum"]);
    $lama_usaha = htmlspecialchars($dataPost["lama_usaha"]);
    $jml_unit_usaha = htmlspecialchars($dataPost["jml_unit_usaha"]);
    $total_modal = htmlspecialchars($dataPost["total_modal"]);
    $perkembangan_modal = htmlspecialchars($dataPost["perkembangan_modal"]);
    $selisih_modal = htmlspecialchars($dataPost["selisih_modal"]); // Hapus abs()
    $klasifikasi = htmlspecialchars($dataPost["klasifikasi"]);

    // Debugging data yang akan disimpan
    echo "Total Modal: $total_modal, Perkembangan Modal: $perkembangan_modal, Selisih Modal: $selisih_modal";

    $query = "INSERT INTO `dataset` (id, kecamatan, desa, nama_bumdes, status_badan_hukum, lama_usaha, jml_unit_usaha, total_modal, perkembangan_modal, selisih_modal, klasifikasi) VALUES (null, '$kecamatan', '$desa', '$nama_bumdes', '$status_badan_hukum', '$lama_usaha', '$jml_unit_usaha', '$total_modal', '$perkembangan_modal', '$selisih_modal', '$klasifikasi')";
    $hasil = $conn->query($query);
    return $hasil ? true : false;
}

// Fungsi untuk mengambil data berdasarkan ID
function ambildataBerdasarkanId(int $id) {
    $conn = koneksiDatabase();
    $query = "SELECT * FROM `dataset` WHERE id=$id";
    $hasil = $conn->query($query);
    if ($hasil->num_rows > 0) {
        return $hasil->fetch_assoc();
    }
    return null;
}

// Fungsi untuk mengedit data berdasarkan ID
function editDataBerdasarkanId(array $dataBaru) {
    $conn = koneksiDatabase();
    $id = htmlspecialchars($dataBaru["id"]);
    $kecamatan = htmlspecialchars($dataBaru["kecamatan"]);
    $desa = htmlspecialchars($dataBaru["desa"]);
    $nama_bumdes = htmlspecialchars($dataBaru["nama_bumdes"]);
    $status_badan_hukum = htmlspecialchars($dataBaru["status_badan_hukum"]);
    $lama_usaha = htmlspecialchars($dataBaru["lama_usaha"]);
    $jml_unit_usaha = htmlspecialchars($dataBaru["jml_unit_usaha"]);
    $total_modal = htmlspecialchars($dataBaru["total_modal"]);
    $perkembangan_modal = htmlspecialchars($dataBaru["perkembangan_modal"]);
    $selisih_modal = htmlspecialchars($dataBaru["selisih_modal"]); // Hapus abs()
    $klasifikasi = htmlspecialchars($dataBaru["klasifikasi"]);

    $query = "UPDATE `dataset` SET `kecamatan`='$kecamatan', `desa`='$desa', `nama_bumdes`='$nama_bumdes', status_badan_hukum='$status_badan_hukum', lama_usaha='$lama_usaha', jml_unit_usaha='$jml_unit_usaha', total_modal='$total_modal', perkembangan_modal='$perkembangan_modal', selisih_modal='$selisih_modal', klasifikasi='$klasifikasi' WHERE id=$id";
    $hasil = $conn->query($query);
    return $hasil ? true : false;
}

// Fungsi untuk menghapus data berdasarkan ID
function hapusDataBerdasarkanId(int $id) {
    $conn = koneksiDatabase();
    $query = "DELETE FROM `dataset` WHERE id=$id";
    $hasil = $conn->query($query);
    return $hasil ? true : false;
}

// Fungsi untuk mengambil semua data hasil hitung
function ambilSemuaDataHasilHitung() {
    $conn = koneksiDatabase();
    $data = [];
    $query = "SELECT * FROM `hasil_hitung`";
    $hasil = $conn->query($query);
    if ($hasil->num_rows > 0) {
        while ($barisData = $hasil->fetch_assoc()) {
            $data[] = $barisData;
        }
    }
    return $data;
}

// Fungsi untuk menyimpan data hasil hitung
function simpanDataHasilHitung(array $dataYangDiuji, string $klasifikasi, int $nilaiK) {
    $conn = koneksiDatabase();
    $kecamatan = htmlspecialchars($dataYangDiuji["kecamatan"]);
    $desa = htmlspecialchars($dataYangDiuji["desa"]);
    $nama_bumdes = htmlspecialchars($dataYangDiuji["nama_bumdes"]);
    $status_badan_hukum = htmlspecialchars($dataYangDiuji["status_badan_hukum"]);
    $lama_usaha = htmlspecialchars($dataYangDiuji["lama_usaha"]);
    $jml_unit_usaha = htmlspecialchars($dataYangDiuji["jml_unit_usaha"]);
    $total_modal = htmlspecialchars($dataYangDiuji["total_modal"]);
    $perkembangan_modal = htmlspecialchars($dataYangDiuji["perkembangan_modal"]);
    $selisih_modal = htmlspecialchars($dataYangDiuji["selisih_modal"]); // Pastikan tidak ada perubahan

    // Debugging data yang akan disimpan
    echo "Data yang disimpan: <br>";
    echo "kecamatan: $kecamatan<br>";
    echo "desa: $desa<br>";
    echo "nama_bumdes: $nama_bumdes<br>";
    echo "status_badan_hukum: $status_badan_hukum<br>";
    echo "lama_usaha: $lama_usaha<br>";
    echo "jml_unit_usaha: $jml_unit_usaha<br>";
    echo "total_modal: $total_modal<br>";
    echo "perkembangan_modal: $perkembangan_modal<br>";
    echo "selisih_modal: $selisih_modal<br>";
    echo "klasifikasi: $klasifikasi<br>";

    $query = "INSERT INTO `hasil_hitung` (id, kecamatan, desa, nama_bumdes, status_badan_hukum, lama_usaha, jml_unit_usaha, total_modal, perkembangan_modal, selisih_modal, klasifikasi, nilai_k) VALUES (null, '$kecamatan', '$desa', '$nama_bumdes', '$status_badan_hukum', '$lama_usaha', '$jml_unit_usaha', '$total_modal', '$perkembangan_modal', '$selisih_modal', '$klasifikasi', '$nilaiK')";

    // Debugging query
    echo "Query: $query<br>";

    $hasil = $conn->query($query);
    if (!$hasil) {
        echo "Error: " . $conn->error;
    }
    return $hasil ? true : false;
}



// Fungsi untuk menghapus data hasil hitung berdasarkan ID
function hapusDataHasilHitungBerdasarkanId(int $id) {
    $conn = koneksiDatabase();
    $query = "DELETE FROM `hasil_hitung` WHERE id=$id";
    $hasil = $conn->query($query);
    return $hasil ? true : false;
}

?>
