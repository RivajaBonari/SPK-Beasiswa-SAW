<?php
include './config.php';

// Ambil data mahasiswa yang aktif
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

// Ambil kriteria dan bobot
$queryKriteria = "SELECT * FROM kriteria";
$resultKriteria = mysqli_query($conn, $queryKriteria);

$kriteria = [];
$bobot = [];
$sifat = [];
$namaField = [];

while ($row = mysqli_fetch_assoc($resultKriteria)) {
    $id = $row['id_kriteria'];
    $field = $row['nama_field'];
    
    $kriteria[$id] = $row['nama_kriteria'];
    $namaField[$id] = $field;
    $sifat[$id] = strtolower($row['sifat']); // jadi lowercase agar konsisten
    $bobot[$id] = (float)$row['bobot']; // bobot sudah dalam bentuk desimal, jangan dibagi 100 lagi
}

// Hitung nilai max dan min untuk masing-masing field
$maxValues = [];
$minValues = [];

foreach ($namaField as $id => $field) {
    $column = array_column($data, $field);
    $maxValues[$field] = max($column);
    $minValues[$field] = min($column);
}

// Kosongkan tabel perangkingan
mysqli_query($conn, "TRUNCATE TABLE perangkingan");

// Proses normalisasi dan perangkingan
foreach ($data as $d) {
    $normalisasi = [];
    $nilaiAkhir = 0;

    foreach ($namaField as $id => $field) {
        $nilai = (float)$d[$field];

        // Normalisasi
        if ($sifat[$id] == 'benefit') {
            $n = $nilai / ($maxValues[$field] ?: 1); // hindari pembagian 0
        } else { // cost
            $n = ($minValues[$field] ?: 1) / ($nilai ?: 1);
        }

        $normalisasi[$field] = $n;
        $nilaiAkhir += $n * $bobot[$id];
    }

    // Siapkan kolom dan nilai untuk insert
    $fieldNames = ['id_pendaftaran'];
    $fieldValues = ["'{$d['id_pendaftaran']}'"];

    foreach ($normalisasi as $field => $value) {
        $fieldNames[] = "{$field}_normalisasi";
        $fieldValues[] = round($value, 4);
    }

    $fieldNames[] = "nilai_akhir";
    $fieldValues[] = round($nilaiAkhir, 4);

    // Insert ke tabel perangkingan
    $sql = "INSERT INTO perangkingan (" . implode(', ', $fieldNames) . ") VALUES (" . implode(', ', $fieldValues) . ")";
    mysqli_query($conn, $sql);
}

// Sukses
echo "<script>alert('Proses perangkingan berhasil!'); window.location.href = '../html/perangkingan.php';</script>";
?>
