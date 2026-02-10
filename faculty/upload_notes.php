<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'faculty') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['upload'])) {
    $courseId = $_POST['course_id'];
    $facultyId = $_SESSION['user_id'];

    $fileName = $_FILES['note_file']['name'];
    $tmpName = $_FILES['note_file']['tmp_name'];

    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($fileName);

    if (move_uploaded_file($tmpName, $targetFile)) {
        mysqli_query($conn, "INSERT INTO notes (faculty_id, course_id, file) 
                             VALUES ($facultyId, $courseId, '$fileName')");
        header("Location: dashboard.php");
    } else {
        echo "File upload failed.";
    }
}
