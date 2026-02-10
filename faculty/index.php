<?php
session_start();
require_once "../includes/db.php";

// Access control
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'faculty') {
    header("Location: ../login.php");
    exit();
}

$facultyId = $_SESSION['user_id'];

// Fetch courses (for now, show all courses)
$coursesQuery = mysqli_query($conn, "SELECT * FROM courses");

// Fetch students (simple list)
$studentsQuery = mysqli_query($conn, "
    SELECT u.id, u.name, u.email 
    FROM users u 
    WHERE u.role = 'student'
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Faculty Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        .header {
            background: #203a43;
            color: #fff;
            padding: 15px;
        }

        .container {
            padding: 20px;
        }

        .card {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
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
        }

        .logout {
            float: right;
            color: #fff;
            text-decoration: none;
        }

        input,
        select {
            padding: 8px;
            width: 100%;
            margin: 5px 0;
        }

        button {
            padding: 8px 15px;
            background: #203a43;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0f2027;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Faculty Dashboard</h2>
        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="container">

        <!-- Upload Notes -->
        <div class="card">
            <h3>📥 Upload Notes</h3>
            <form method="POST" action="upload_notes.php" enctype="multipart/form-data">
                <label>Select Course</label>
                <select name="course_id" required>
                    <?php while ($course = mysqli_fetch_assoc($coursesQuery)) { ?>
                        <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['title']) ?></option>
                    <?php } ?>
                </select>

                <label>Select File (PDF)</label>
                <input type="file" name="note_file" required>

                <button type="submit" name="upload">Upload</button>
            </form>
        </div>

        <!-- Assign Marks -->
        <div class="card">
            <h3>📝 Assign Marks</h3>
            <form method="POST" action="assign_marks.php">
                <label>Select Student</label>
                <select name="student_id" required>
                    <?php while ($student = mysqli_fetch_assoc($studentsQuery)) { ?>
                        <option value="<?= $student['id'] ?>">
                            <?= htmlspecialchars($student['name']) ?> (<?= $student['email'] ?>)
                        </option>
                    <?php } ?>
                </select>

                <label>Select Course</label>
                <?php
                $coursesQuery2 = mysqli_query($conn, "SELECT * FROM courses");
                ?>
                <select name="course_id" required>
                    <?php while ($course = mysqli_fetch_assoc($coursesQuery2)) { ?>
                        <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['title']) ?></option>
                    <?php } ?>
                </select>

                <label>Marks</label>
                <input type="number" name="marks" min="0" max="100" required>

                <button type="submit" name="save_marks">Save Marks</button>
            </form>
        </div>

    </div>

</body>

</html>