<?php
include './config.php';

// Ambil data hanya yang aktif
$query = "SELECT * FROM pendaftaran WHERE status = 'Aktif'";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Cek jika tidak ada data
if (count($data) === 0) {
    echo "<script>alert('Tidak ada data aktif untuk diproses.'); window.location.href = '../html/perangkingan.php';</script>";
    exit;
}

// Ambil data kriteria dan bobot dari tabel kriteria
$queryKriteria = "SELECT * FROM kriteria";
$resultKriteria = mysqli_query($conn, $queryKriteria);

// Inisialisasi array untuk menyimpan informasi kriteria
$kriteria = [];
$bobot = [];
$sifat = [];
$namaField = [];

while ($rowKriteria = mysqli_fetch_assoc($resultKriteria)) {
    $id = $rowKriteria['id_kriteria'];
    $field = $rowKriteria['nama_field'];
    
    $kriteria[$id] = $rowKriteria['nama_kriteria'];
    $namaField[$id] = $field;
    $sifat[$id] = $rowKriteria['sifat'];
    
    // Konversi bobot dari persen ke desimal
    $bobot[$id] = $rowKriteria['bobot'] / 100;
}

// Inisialisasi nilai maksimum dan minimum untuk setiap kriteria
$maxValues = [];
$minValues = [];

// Cari nilai maksimum dan minimum untuk setiap kriteria
foreach ($namaField as $id => $field) {
    if ($field && isset($data[0][$field])) {
        $values = array_column($data, $field);
        $maxValues[$field] = max($values);
        $minValues[$field] = min($values);
    }
}

// Kosongkan tabel perangkingan terlebih dahulu
mysqli_query($conn, "TRUNCATE TABLE perangkingan");

// Hitung nilai SAW dan simpan ke tabel perangkingan
foreach ($data as $d) {
    // Inisialisasi array untuk menyimpan nilai normalisasi
    $normalisasi = [];
    $nilaiAkhir = 0;
    
    // Hitung normalisasi untuk setiap kriteria
    foreach ($namaField as $id => $field) {
        if ($field && isset($d[$field]) && isset($maxValues[$field]) && isset($minValues[$field])) {
            $nilai = (float)$d[$field];
            
            // Normalisasi berdasarkan sifat (benefit/cost)
            if ($sifat[$id] == 'benefit') {
                // Untuk kriteria benefit, nilai lebih tinggi lebih baik
                $normalisasi[$field] = $nilai / max($maxValues[$field], 1); // Hindari pembagian dengan 0
            } else {
                // Untuk kriteria cost, nilai lebih rendah lebih baik
                $normalisasi[$field] = $minValues[$field] / max($nilai, 1); // Hindari pembagian dengan 0
            }
            
            // Hitung nilai akhir dengan mengalikan normalisasi dengan bobot
            $nilaiAkhir += $normalisasi[$field] * $bobot[$id];
        } else {
            $normalisasi[$field] = 0;
        }
    }
    
    // Siapkan data untuk disimpan ke tabel perangkingan
    $fieldNames = [];
    $fieldValues = [];
    
    $fieldNames[] = "id_pendaftaran";
    $fieldValues[] = "'{$d['id_pendaftaran']}'";
    
    foreach ($normalisasi as $field => $value) {
        $fieldNames[] = "{$field}_normalisasi";
        $fieldValues[] = round($value, 4); // Pembulatan untuk menghindari angka yang terlalu panjang
    }
    
    $fieldNames[] = "nilai_akhir";
    $fieldValues[] = round($nilaiAkhir, 4);
    
    // Simpan ke tabel perangkingan
    $sql = "INSERT INTO perangkingan (" . implode(", ", $fieldNames) . ") 
            VALUES (" . implode(", ", $fieldValues) . ")";
    
    mysqli_query($conn, $sql);
}

// Notifikasi dan redirect ke halaman perangkingan
echo "<script>alert('Proses perangkingan berhasil!'); window.location.href = '../html/perangkingan.php';</script>";
?>