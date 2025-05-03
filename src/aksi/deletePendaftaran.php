<?php
include("../backend/config.php");

if (isset($_GET['id'])) {
    $id_pendaftaran = $_GET['id'];

    $sql = "DELETE FROM pendaftaran WHERE id_pendaftaran = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pendaftaran);

    if ($stmt->execute()) {
        // Berhasil hapus
        header("Location: ../html/pendaftaran.php?pesan=hapus_berhasil");
        exit();
    } else {
        echo "Gagal menghapus data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID tidak ditemukan.";
}
?>
