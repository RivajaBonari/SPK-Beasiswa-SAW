<?php
include("config.php");
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$exe = $conn->query($sql);
$banyak = $exe->num_rows;

if ($banyak == 1) {
    $_SESSION['username'] = $username;
    $_SESSION['login'] = true;
    header("Location: ../html/index.php");
} else {
    $_SESSION['error'] = "Username atau Password salah!";
    header("Location: ../html/authentication-login.php");
    exit;
}
