<?php
session_start();
require_once "../includes/db.php";
if ($_SESSION['role'] != 'admin') die("Access denied");

// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

// Fetch users
$users = mysqli_query($conn, "SELECT id, name, email, role FROM users");

// Fetch courses
// $courses = mysqli_query($conn, "SELECT * FROM courses");

// Fetch news (create table if not exists)
mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )
");
$news = mysqli_query($conn, "SELECT * FROM news ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>VDC | Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <div class="header">
        <img src="../assets/images/logo.png" alt="logo" id="logo">
        <h2>Admin Panel</h2>
        <a href="../logout.php" class="logout">Logout</a>
    </div>
    <main>
        <aside>
            <h2>Quick Links</h2>
            <h2>Users</h2>
            <ul>
                <li><a href="?students">Students</a></li>
                <li><a href="?faculty">Faculty</a></li>
                <li><a href="?users">All Users</a></li>
            </ul>
            <h2>academics</h2>
            <ul>
                <li><a href="?department">Departments</a></li>
                <li><a href="?courses">Courses</a></li>
            </ul>
            <h2>Quiz</h2>
            <h2><a href="?news">news</a></h2>
            <h2><a href="?slider">Home Page Slider</a></h2>
        </aside>

        <div class="container">

            <?php
            if (isset($_GET['students'])) {
                include "../components/view_students.php";
            }

            if (isset($_GET['faculty'])) {
                include "./add_faculty.php";
            }

            if (isset($_GET['department'])) {
                include "./add_department.php";
            }

            if (isset($_GET['streams'])) {
                include "./streams.php";
            }

            if (isset($_GET['courses'])) {
                include "./add_course.php";
            }

            if (isset($_GET['users'])) {
                include "./all_users.php";
            }
            if (isset($_GET['news'])) {
                include "./add_news.php";
            }
            if (isset($_GET['slider'])) {
                include "./upload_slider.php";
            }
            ?>




        </div>
    </main>
</body>

</html>