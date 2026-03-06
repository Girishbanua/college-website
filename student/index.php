<?php
session_start();
require_once "../includes/db.php";

// Access control
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user info
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id = $userId");
$user = mysqli_fetch_assoc($userQuery);
$uemail = $user['email'];

//Fetch student info
$studentQuery = mysqli_query($conn, "SELECT * FROM students where email = '$uemail'");
$student = mysqli_fetch_assoc($studentQuery);
$sid = $student['student_id'];
$did = $student['department_id'];
$sem = $student['semester'];
$img = $student['photo'];
// Fetch courses
$coursesQuery = mysqli_query($conn, "SELECT * FROM courses where department_id = $did and semester = $sem");

//Fetch faculty details
$facultyQuery = mysqli_query($conn, "SELECT * from faculty");
$faculty = mysqli_fetch_assoc($facultyQuery);

// Fetch marks
$marksQuery = mysqli_query($conn, "
    SELECT c.title, m.marks 
    FROM marks m
    JOIN courses c ON c.id = m.course_id
    WHERE m.student_id = $userId
");

// Fetch notes
$notesQuery = mysqli_query($conn, "
    SELECT c.title, n.file 
    FROM notes n
    JOIN courses c ON c.id = n.course_id
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .header h2 {
            text-transform: capitalize;
        }

        .student_proflie_pic {
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            object-position: top;
        }

        .dept_img {
            width: 100px;
            background: #ffffff47;
            border-radius: 20%;
            padding: 10px;
        }

        .dept_img::after {
            content: "Department of BCA";
        }

        aside h2 {
            transition: all ease-in-out 0.3s;
        }

        aside h2:hover {
            transform: scale(1.05px);
        }

        .container {
            padding: 20px;
        }

        .card {
            min-width: 300px;
            min-height: 300px;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgb(0 0 0 / 35%);
        }

        h3 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .logout {
            float: right;
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <header class="header">
        <img src="../assets/images/logo.png" alt="logo" id="logo">
        <div style="display: flex;align-items: center;gap: 15px;">
            <h2>Welcome, <?= htmlspecialchars($user['name']) ?></h2>
            <img class="student_proflie_pic" src="../assets/images/students/<?= $img ?>" alt="profile picture" style="width: 60px;">
            <a href="../logout.php" class="logout" onclick="return confirm('Do you really want to logout?')">Logout</a>
        </div>
    </header>
    <main>
        <aside>
            <div style="text-align: center;">
                <?php
                $logo_stmnt = mysqli_query($conn, "SELECT department_name,logo from department where department_id = $did");
                $logo = mysqli_fetch_assoc($logo_stmnt);
                echo "<img class='dept_img' src='../assets/images/department_logos/{$logo['logo']}' alt='department_logo'>";
                ?>
                <p style="margin: 0;"><?= $logo['department_name'] ?></p>
            </div>
            <h2>Quick Links</h2>
            <a href="../pages/quiz.php?sid=<?= $sid ?>&sem=<?= $sem ?>" target="_blank">
                <h2 class="special">Quiz</h2>
            </a>
            <h2>My Teachers</h2>
            <h2>My classmates</h2>
            <h2>news</h2>
        </aside>
        <div class="container">
            <!-- ----------------- notice board-------------------- -->
            <div class="card">
                <h3>Notice Board</h3>
                <p>No Notice yet </p>
            </div>
            <!-- ----------------- Enrolled Courses-------------------- -->
            <div class="card">
                <h3>📚 Enrolled Courses</h3>
                <?php if (mysqli_num_rows($coursesQuery) == 0)
                    echo "<p>No courses enrolled yet.</p>";
                else {
                ?>
                    <table>
                        <thead>
                            <th>Course Code</th>
                            <th>Course Title</th>
                        </thead>
                        <tbody>
                            <?php

                            while ($course = mysqli_fetch_assoc($coursesQuery)) { ?>
                                <tr>
                                    <td><?= $course['course_code'] ?></td>
                                    <td><?= $course['title'] ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                <?php } ?>
            </div>

            <div class="card">
                <h3>📝 Your Marks</h3>
                <table>
                    <tr>
                        <th>Course</th>
                        <th>Marks</th>
                    </tr>
                    <?php while ($mark = mysqli_fetch_assoc($marksQuery)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($mark['title']) ?></td>
                            <td><?= htmlspecialchars($mark['marks']) ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php if (mysqli_num_rows($marksQuery) == 0) echo "<p>No marks available yet.</p>"; ?>
            </div>

            <div class="card">
                <h3>📥 Download Notes</h3>
                <ul>
                    <?php while ($note = mysqli_fetch_assoc($notesQuery)) { ?>
                        <li>
                            <?= htmlspecialchars($note['title']) ?> -
                            <a href="../uploads/<?= $note['file'] ?>" target="_blank">Download</a>
                        </li>
                    <?php } ?>
                </ul>
                <?php if (mysqli_num_rows($notesQuery) == 0) echo "<p>No notes uploaded yet.</p>"; ?>
            </div>

        </div>
    </main>


</body>

</html>