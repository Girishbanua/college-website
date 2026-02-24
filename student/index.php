<?php
session_start();
require_once "../includes/db.php";

// Access control
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch student info
$userQuery = mysqli_query($conn, "SELECT name FROM users WHERE id = $userId");
$user = mysqli_fetch_assoc($userQuery);

// Fetch enrolled courses
$coursesQuery = mysqli_query($conn, "
    SELECT c.title 
    FROM courses c
    JOIN enrollments e ON c.id = e.course_id
    WHERE e.student_id = $userId
");

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
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .header h2 {
            text-transform: capitalize;
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
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
            <img src="../assets/images/students/profile.png" alt="profile picture" style="width: 60px;">
            <a href="../logout.php" class="logout" onclick="return confirm('Do you really want to logout?')">Logout</a>
        </div>
    </header>
    <main>
        <aside>
            <h2>Quick Links</h2>
            <h2>Quiz</h2>
            <h2>My Teachers</h2>
            <h2>My classmates</h2>
            <h2>news</h2>
        </aside>
        <div class="container">
            <div class="card">
                <h3>Notice Board</h3>
            </div>
            <div class="card">
                <h3>📚 Enrolled Courses</h3>
                <ul>
                    <?php while ($course = mysqli_fetch_assoc($coursesQuery)) { ?>
                        <li><?= htmlspecialchars($course['title']) ?></li>
                    <?php } ?>
                </ul>
                <?php if (mysqli_num_rows($coursesQuery) == 0) echo "<p>No courses enrolled yet.</p>"; ?>
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