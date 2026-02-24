<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'faculty') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['upload'])) {

    $facultyId = $_SESSION['user_id'];
    $department_id = $_POST['department'];
    $notes_title = $_POST['notes_title'];

    $fileName = $_FILES['note_file']['name'];
    $tmpName = $_FILES['note_file']['tmp_name'];

    $targetDir = "../uploads/notes/";
    $targetFile = $targetDir . basename($fileName);

    if (move_uploaded_file($tmpName, $targetFile)) {
        mysqli_query($conn, "INSERT INTO notes (faculty_id, file, department_id, notes_title) 
                             VALUES ($facultyId, '$fileName', $department_id , '$notes_title' )");
        echo "<script>alert('File uploaded.')</script>";
        header("Location: index.php");
    } else {
        echo "<script>alert('File upload failed.')</script>";
    }
}
