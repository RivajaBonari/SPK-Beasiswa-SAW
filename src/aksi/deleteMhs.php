<?php
$x = $_GET['npm'];
include("../backend/config.php");
$sql = "delete from mahasiswa where npm='$x'";
$result = $conn->query($sql);
if ($result) {
header("location:../html/data.php");
}