<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'faculty') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['save_marks'])) {
    $studentId = $_POST['student_id'];
    $courseId = $_POST['course_id'];
    $marks = $_POST['marks'];

    // Check if marks already exist
    $check = mysqli_query($conn, "SELECT id FROM marks WHERE student_id=$studentId AND course_id=$courseId");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE marks SET marks=$marks WHERE student_id=$studentId AND course_id=$courseId");
    } else {
        mysqli_query($conn, "INSERT INTO marks (student_id, course_id, marks) 
                             VALUES ($studentId, $courseId, $marks)");
    }

    header("Location: dashboard.php");
}
