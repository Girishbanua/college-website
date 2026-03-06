<?php
mysqli_report(MYSQLI_REPORT_OFF);
require_once "../includes/db.php";
if ($_SESSION['role'] != 'admin') die("Access denied");
if (isset($_POST['add_course'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $course_id = $_POST['course_code'];
    $did = $_POST['department'];
    $fid = $_POST['faculty_code'];
    $sem = $_POST['semester'];

    $stmnt = $conn->prepare("INSERT INTO courses 
    (title, description, course_code, semester, department_id, faculty_code) 
    VALUES (?, ?, ?, ?, ?,?)");

    $stmnt->bind_param("sssiis", $title, $desc, $course_id, $sem, $did, $fid);

    $message = "";
    $type = ""; //success or error

    if ($stmnt->execute()) {
        $message = "Course added successfully";
        $type = "success";
    } else {
        $message = "Error: " . $stmnt->error;
        $type = "error";
    }
    // $stmnt->close();
}

?>
<div style="display: flex; flex-direction: column; align-items: center; position: relative;">

    <?php if (!empty($message)) { ?>
        <div id="alertBox" class="card alert <?= $type ?>"><?= $message ?></div>
    <?php } ?>
    <div class="card">
        <h3>➕ Add Course</h3>
        <form method="POST" action="">
            <select name="department" id="department" required>
                <option value="">Department</option>
                <?php
                $stmnt = "Select * from department";
                $result = mysqli_query($conn, $stmnt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $dname = $row['department_name'];
                    $deptid = $row['department_id'];
                    echo "<option value='$deptid'>$dname</option>";
                }
                ?>
            </select>
            <select name="semester" id="semester" required>
                <option value="">semester</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
            <input type="text" name="title" placeholder="Course title" required>
            <input type="text" name="course_code" placeholder="course code" required>
            <textarea name="description" placeholder="Course description"></textarea>
            <select name="faculty_code" id="faculty" required>
                <option value="">Select faculty</option>
                <?php

                $stmnt = mysqli_query($conn, "SELECT * from faculty");
                while ($row = mysqli_fetch_assoc($stmnt)) {
                    $fname = $row['first_name'] . " " . $row['last_name'];
                    $fid = $row['faculty_code'];
                    echo "<option value='$fid'>$fname</option>";
                }
                ?>
            </select>
            <button type="submit" name="add_course">Add Course</button>
        </form>
    </div>
</div>

<script>
    setTimeout(function() {
        let alertBox = document.getElementById("alertBox");
        if (alertBox) {
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);
</script>