<?php
include './config.php';
session_start();


// 1. Ambil data mahasiswa yang statusnya Aktif
$query = "SELECT * FROM pendaftaran WHERE status = 'Aktif'";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

if (count($data) === 0) {
    echo "<script>alert('Tidak ada data aktif untuk diproses.'); window.location.href = '../html/perangkingan.php';</script>";
    exit;
}

// 2. Ambil data kriteria
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
    $sifat[$id] = strtolower($row['sifat']); // benefit/cost
    $bobot[$id] = (float)$row['bobot'];      // bobot (desimal)
}

// 3. Ambil nilai kecocokan dari sub_kriteria berdasarkan nilai masing-masing pendaftar
// Disimpan sebagai matrix keputusan awal
$matrixKeputusan = []; // [id_pendaftaran][field] = nilai_kecocokan

foreach ($data as $d) {
    $id_pendaftaran = $d['id_pendaftaran'];
    $matrixKeputusan[$id_pendaftaran] = [];

    foreach ($namaField as $id_kriteria => $field) {
        $nilai = $d[$field];

        // Cari sub_kriteria yang sesuai
        $querySub = "SELECT nilai_kecocokan FROM sub_kriteria 
                     WHERE id_kriteria = $id_kriteria 
                     AND $nilai BETWEEN nilai_min AND nilai_max
                     LIMIT 1";
        $resultSub = mysqli_query($conn, $querySub);

        $skor = 0;
        if ($rowSub = mysqli_fetch_assoc($resultSub)) {
            $skor = (float)$rowSub['nilai_kecocokan'];
        }

        $matrixKeputusan[$id_pendaftaran][$field] = $skor;
    }
}

// 4. Hitung nilai max & min dari setiap kolom kriteria (untuk normalisasi)
$maxValues = [];
$minValues = [];

foreach ($namaField as $id => $field) {
    $col = array_column(array_map(fn($x) => $x[$field], $matrixKeputusan), null);
    $maxValues[$field] = max($col);
    $minValues[$field] = min($col);
}

// 5. Kosongkan tabel perangkingan
mysqli_query($conn, "TRUNCATE TABLE perangkingan");

// 6. Proses normalisasi & hitung nilai akhir
foreach ($matrixKeputusan as $id_pendaftaran => $nilai) {
    $normalisasi = [];
    $nilaiAkhir = 0;

    foreach ($namaField as $id_kriteria => $field) {
        $v = $nilai[$field];

        // === 🔹 NORMALISASI
        if ($sifat[$id_kriteria] == 'benefit') {
            $n = $v / ($maxValues[$field] ?: 1);
        } else {
            $n = ($minValues[$field] ?: 1) / ($v ?: 1);
        }

        $normalisasi[$field] = round($n, 4);

        // === 🔸 HITUNG NILAI R
        $nilaiAkhir += $n * $bobot[$id_kriteria];
    }

    // 7. Simpan ke tabel perangkingan
    $fieldNames = ['id_pendaftaran'];
    $fieldValues = ["'$id_pendaftaran'"];

    foreach ($normalisasi as $field => $val) {
        $fieldNames[] = "{$field}_normalisasi";
        $fieldValues[] = $val;
    }

    $fieldNames[] = "nilai_akhir";
    $fieldValues[] = round($nilaiAkhir, 4);

    $sql = "INSERT INTO perangkingan (" . implode(', ', $fieldNames) . ") VALUES (" . implode(', ', $fieldValues) . ")";
    mysqli_query($conn, $sql);
}

// 8. Sukses
// echo "<script>alert('Proses perangkingan berhasil!'); window.location.href = '../html/perangkingan.php';</script>";
include('../html/header.php');
$_SESSION['success'] = "Berhasil memproses perangkingan";
header("Location: ../html/perangkingan.php");
exit;
?>
