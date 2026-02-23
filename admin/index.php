<?php
session_start();
require_once "../includes/db.php";

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
            <h2>Users</h2>
            <ul>
                <li><a href="?students">Students</a></li>
                <li><a href="?faculty">Faculty</a></li>
                <li><a href="?users">All Users</a></li>
            </ul>
            <h2>academics</h2>
            <ul>
                <li><a href="?streams">Streams</a></li>
                <li><a href="?department">Departments</a></li>
                <li><a href="?courses">Courses</a></li>
            </ul>
            <h2>Quiz</h2>
            <h2>news</h2>
            <h2>Home Page Slider</h2>
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
                include "./add_faculty.php";
            }

            if (isset($_GET['courses'])) {
                include "./add_course.php";
            }

            if (isset($_GET['users'])) {
                include "./all_users.php";
            }
            ?>
            <div class="grid">

                <!-- Add Department -->



                <!-- Add Course -->


                <!-- Add Faculty -->


                <!-- Post News -->






                <hr>



            </div>

            <br>

            <!-- Users List -->


            <!-- Courses List -->
            <!-- <div class="card">
                <h3>📚 Courses</h3>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($c = mysqli_fetch_assoc($courses)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($c['title']) ?></td>
                            <td><?= htmlspecialchars($c['description']) ?></td>
                            <td>
                                <a class="btn danger" href="delete_course.php?id=<?= $c['id'] ?>" onclick="return confirm('Delete course?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div> -->

            <!-- News List -->
            <!-- <div class="card">
                <h3>📰 Latest News</h3>
                <ul>
                    <?php while ($n = mysqli_fetch_assoc($news)) { ?>
                        <li><strong><?= htmlspecialchars($n['title']) ?></strong> – <?= htmlspecialchars($n['content']) ?></li>
                    <?php } ?>
                </ul>
            </div> -->

        </div>
    </main>
</body>

</html>