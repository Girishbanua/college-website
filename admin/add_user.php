<?php
session_start();
require_once "../includes/db.php";
if ($_SESSION['role'] != 'admin') die("Access denied");

$name = $_POST['name'];
$email = $_POST['email'];
$role = $_POST['role'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($conn, "INSERT INTO users (name, email, password, role) VALUES ('$name','$email','$password','$role')");
header("Location: dashboard.php");
