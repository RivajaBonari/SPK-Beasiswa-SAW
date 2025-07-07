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
$matrixKeputusan = [];  
  
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
  
// === IMPLEMENTASI METODE TOPSIS ===  
  
// LANGKAH 1: Normalisasi Matrix Keputusan (Vector Normalization)  
$sumSquares = [];  
foreach ($namaField as $id => $field) {  
    $sumSquares[$field] = 0;  
    foreach ($matrixKeputusan as $nilai) {  
        $sumSquares[$field] += pow($nilai[$field], 2);  
    }  
    $sumSquares[$field] = sqrt($sumSquares[$field]);  
}  
  
$matrixNormalisasi = [];  
foreach ($matrixKeputusan as $id_pendaftaran => $nilai) {  
    $matrixNormalisasi[$id_pendaftaran] = [];  
    foreach ($namaField as $id_kriteria => $field) {  
        $r = $nilai[$field] / ($sumSquares[$field] ?: 1);  
        $matrixNormalisasi[$id_pendaftaran][$field] = $r;  
    }  
}  
  
// LANGKAH 2: Matrix Normalisasi Terbobot  
$matrixTerbobot = [];  
foreach ($matrixNormalisasi as $id_pendaftaran => $nilai) {  
    $matrixTerbobot[$id_pendaftaran] = [];  
    foreach ($namaField as $id_kriteria => $field) {  
        $v = $nilai[$field] * $bobot[$id_kriteria];  
        $matrixTerbobot[$id_pendaftaran][$field] = $v;  
    }  
}  
  
// LANGKAH 3: Menentukan Solusi Ideal Positif (A+) dan Negatif (A-)  
$idealPositif = [];  
$idealNegatif = [];  
  
foreach ($namaField as $id_kriteria => $field) {  
    $kolom = array_column($matrixTerbobot, $field);  
      
    if ($sifat[$id_kriteria] == 'benefit') {  
        $idealPositif[$field] = max($kolom);  
        $idealNegatif[$field] = min($kolom);  
    } else { // cost  
        $idealPositif[$field] = min($kolom);  
        $idealNegatif[$field] = max($kolom);  
    }  
}  
  
// LANGKAH 4: Menghitung Jarak ke Solusi Ideal  
$jarakPositif = [];  
$jarakNegatif = [];  
  
foreach ($matrixTerbobot as $id_pendaftaran => $nilai) {  
    $sumPositif = 0;  
    $sumNegatif = 0;  
      
    foreach ($namaField as $id_kriteria => $field) {  
        $sumPositif += pow($nilai[$field] - $idealPositif[$field], 2);  
        $sumNegatif += pow($nilai[$field] - $idealNegatif[$field], 2);  
    }  
      
    $jarakPositif[$id_pendaftaran] = sqrt($sumPositif);  
    $jarakNegatif[$id_pendaftaran] = sqrt($sumNegatif);  
}  
  
// LANGKAH 5: Menghitung Nilai Preferensi (Closeness Coefficient)  
$nilaiPreferensi = [];  
foreach ($jarakPositif as $id_pendaftaran => $dPositif) {  
    $dNegatif = $jarakNegatif[$id_pendaftaran];  
    $c = $dNegatif / ($dPositif + $dNegatif);  
    $nilaiPreferensi[$id_pendaftaran] = $c;  
}  
  
// 5. Kosongkan tabel perangkingan  
mysqli_query($conn, "TRUNCATE TABLE perangkingan");  
  
// 6. Simpan hasil ke tabel perangkingan  
foreach ($matrixNormalisasi as $id_pendaftaran => $normalisasi) {  
    $fieldNames = ['id_pendaftaran'];  
    $fieldValues = ["'$id_pendaftaran'"];  
  
    // Simpan nilai normalisasi  
    foreach ($normalisasi as $field => $val) {  
        $fieldNames[] = "{$field}_normalisasi";  
        $fieldValues[] = round($val, 4);  
    }  
  
    // Simpan nilai preferensi sebagai nilai akhir  
    $fieldNames[] = "nilai_akhir";  
    $fieldValues[] = round($nilaiPreferensi[$id_pendaftaran], 4);  
  
    $sql = "INSERT INTO perangkingan (" . implode(', ', $fieldNames) . ") VALUES (" . implode(', ', $fieldValues) . ")";  
    mysqli_query($conn, $sql);  
}  
  
// 7. Sukses  
include('../html/header.php');  
$_SESSION['success'] = "Berhasil memproses perangkingan dengan metode TOPSIS";  
header("Location: ../html/perangkingan.php");  
exit;  
?>