<?php
session_start();
require_once "../includes/db.php";
if ($_SESSION['role'] != 'admin') die("Access denied");

$title = $_POST['title'];
$desc = $_POST['description'];

mysqli_query($conn, "INSERT INTO courses (title, description) VALUES ('$title', '$desc')");
header("Location: dashboard.php");
