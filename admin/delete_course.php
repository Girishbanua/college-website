<?php
session_start();
require_once "../includes/db.php";
if ($_SESSION['role'] != 'admin') die("Access denied");

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM courses WHERE id=$id");
header("Location: dashboard.php");
