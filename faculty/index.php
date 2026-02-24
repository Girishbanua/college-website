<?php
session_start();
require_once "../includes/db.php";

// // Access control
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'faculty') {
    header("Location: ../login.php");
    exit();
}

$facultyId = $_SESSION['user_id'];

// Fetch courses (for now, show all courses)
$coursesQuery = mysqli_query($conn, "SELECT * FROM courses");

// Fetch students (simple list)
$studentsQuery = mysqli_query($conn, "SELECT * from students");

// Fetch faculty (simple list)
$faculty = mysqli_query($conn, "SELECT * FROM faculty where faculty_code = 'FAC$facultyId'");


?>

<!DOCTYPE html>
<html>

<head>
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            gap: 30px;
        }

        .card {
            height: 350px;
            overflow-y: scroll;
        }

        .card::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }

        button {
            background: #3456b4ff;
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: all ease-in-out 0.3s;
            font-weight: bold;
        }

        button:hover {
            background: lightgreen;
            color: #323232ff;
        }
    </style>
</head>

<body>

    <header class="header">
        <img src="../assets/images/logo.png" alt="logo" id="logo">
        <a href="../logout.php" class="logout" onclick="return confirm('Do you really want to logout?')">Logout</a>
    </header>
    <main>
        <aside>
            <div id="imgContainer">
                <?php
                $row = mysqli_fetch_assoc($faculty);
                ?>
                <div class="imageContainer" style="position: relative;">
                    <img src="../assets/images/faculty/<?= $row['photo'] ?>" alt="Profile Picture" id="profile_image">
                </div>
            </div>
            <div id="designation">
                <h2><?= $row['first_name'] . " " . $row['last_name']  ?></h2>
                <h3><?= $row['designation'] ?></h3>
                <?php
                $did = $row['department_id'];
                $stmnt2 = mysqli_query($conn, "SELECT department_name from department where department_id = $did");
                $dept_name = mysqli_fetch_assoc($stmnt2);
                ?>
                <p>Department of <?= $dept_name['department_name'] ?></p>
            </div>

            <h2>Students</h2>
            <ul>
                <li><a href="">First Year</a></li>
                <li><a href="">Second Year</a></li>
                <li><a href="">Third Year</a></li>
            </ul>
            <h2>Quiz</h2>
            <h2>news</h2>
        </aside>
        <div class="container">

            <!------------------------- Upload Notes --------------------------->
            <div class="card">
                <h3>📥 Upload Notes</h3>
                <form method="POST" action="upload_notes.php" enctype="multipart/form-data">
                    <label>Notes Title</label>
                    <input type="text" placeholder="Enter a title" name="notes_title" required>
                    <label>Select File (PDF)</label>
                    <input type="file" name="note_file" accept="application/pdf" required>
                    <?php
                    echo "<input type='hidden' value='$did' name='department'>";
                    ?>

                    <button type="submit" name="upload">Upload</button>
                </form>
            </div>

            <!----------------------------- Assign Marks ---------------------------------------->
            <div class="card">
                <h3>📝 Assign Marks</h3>
                <form method="POST" action="assign_marks.php">
                    <label>Select Student</label>
                    <select name="exam" required>
                        <option value="">exam type</option>
                        <option value="">Weekly Test</option>
                        <option value="">Monthly Test</option>
                        <option value="">Semester Exam</option>
                    </select>
                    <label>Select Student</label>
                    <select name="student_id" required>
                        <?php while ($student = mysqli_fetch_assoc($studentsQuery)) { ?>
                            <option value="<?= $student['student_id'] ?>">
                                <?= htmlspecialchars($student['student_name']) ?>
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
                    <input type="number" name="marks" min="0" max="100" placeholder="enter full marks" required>
                    <input type="number" name="marks" min="0" max="100" placeholder="enter marks obtained" required>

                    <button type="submit" name="save_marks">Save Marks</button>
                </form>
            </div>

            <!----------------------------- Notes -------------------------------------->
            <div class="card">
                <h3>Notes</h3>
                <?php
                $notesQuery = mysqli_query($conn, "SELECT * from notes where department_id = $did");
                $rows = mysqli_num_rows($notesQuery);
                if ($rows > 0) { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($notesQuery)) {
                                $date = $row['date'];
                                $title = $row['notes_title'];
                                $file = $row['file'];
                                echo "
                                    <tr>
                                        <td>$date</td>
                                        <td>$title</td>
                                        <td><a href='../uploads/notes/$file' target='_blank'><u>click here</u></a></td>
                                    </tr>    
                                ";
                            }
                            ?>
                        </tbody>
                    <?php
                } else {
                    echo "<div>No Notes Uploaded</div>";
                }
                    ?>
                    </table>
            </div>
            <!----------------------------- Students -------------------------------------->
            <div class="card">
                <h3>Students</h3>
                <?php
                $studentsQuery = mysqli_query($conn, "SELECT * from students where department_id = $did");
                $rows = mysqli_num_rows($studentsQuery);
                if ($rows > 0) { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Roll number</th>
                                <th>Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($studentsQuery)) {

                            echo "
                            <tr>                                
                                <td>{$row['student_name']}</td>
                                <td>{$row['roll_number']}</td>
                                <td>{$row['semester']}</td>                                
                            </tr>
                            ";
                        }
                    } else {
                        echo "<div> No students enrolled.</div>";
                    }

                        ?>

                        </tbody>
                    </table>
            </div>
        </div>
    </main>

</body>

</html>