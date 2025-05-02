<?php
include("../backend/config.php");

$npm = $_POST['npm'];
$nama = $_POST['nama_mahasiswa'];
$gender = $_POST['gender'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];

$sql = "UPDATE mahasiswa SET 
          nama_mahasiswa='$nama',
          gender='$gender',
          telepon='$telepon',
          alamat='$alamat'
        WHERE npm='$npm'";

if ($conn->query($sql)) {
    header("Location: ../html/data.php");
    
} else {
    echo "Gagal update data";
}
?>
