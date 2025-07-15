<?php
session_start();
require '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$query->bind_param("ss", $username, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
  $_SESSION['username'] = $username;
  header("Location: dashboard.php");
} else {
  echo "<script>alert('Login gagal!'); window.location='index.php';</script>";
}