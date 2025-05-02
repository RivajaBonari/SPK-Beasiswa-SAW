<?php
include("../backend/config.php");

$npm = $_POST['npm'];
$nama = $_POST['nama_mahasiswa'];
$gender = $_POST['gender'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];

$sql = "INSERT INTO mahasiswa (npm, nama_mahasiswa, gender, telepon, alamat)
        VALUES ('$npm', '$nama', '$gender', '$telepon', '$alamat')";

if ($conn->query($sql)) {
  header("Location: ../html/data.php");
  exit;
} else {
  echo "Gagal menambah data: " . $conn->error;
}
?>
