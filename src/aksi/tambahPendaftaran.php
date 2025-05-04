<?php
// Koneksi ke database
include("../backend/config.php");
session_start();

// Pastikan data yang diperlukan ada dalam request POST
if (isset($_POST['npm']) && isset($_POST['ipk']) && isset($_POST['penghasilan_ortu']) && isset($_POST['tanggungan']) && isset($_POST['organisasi']) && isset($_POST['status'])) {

    // Menangkap data yang dikirimkan melalui form
    $npm = $_POST['npm'];
    $ipk = $_POST['ipk'];
    $penghasilan_ortu = $_POST['penghasilan_ortu'];
    $tanggungan = $_POST['tanggungan'];
    $organisasi = $_POST['organisasi'];
    $status = $_POST['status'];

    // Query untuk memasukkan data pendaftaran ke tabel pendaftaran
    $sql = "INSERT INTO pendaftaran (npm, ipk, penghasilan_ortu, tanggungan, organisasi, status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Persiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("ssssss", $npm, $ipk, $penghasilan_ortu, $tanggungan, $organisasi, $status);

        // Eksekusi statement
        if ($stmt->execute()) {
            include('../html/header.php');
            $_SESSION['success'] = "Berhasil menambah data alternatif!";
            header("Location: ../html/pendaftaran.php");
            exit;
        } else {
            // Jika gagal, beri notifikasi atau alihkan ke halaman dengan pesan error
            echo "Terjadi kesalahan saat menyimpan data.";
        }
    } else {
        echo "Terjadi kesalahan saat menyiapkan query.";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    // Jika data tidak lengkap
    echo "Data tidak lengkap.";
}
