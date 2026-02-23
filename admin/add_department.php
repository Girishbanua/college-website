<?php
require_once "../includes/db.php";

/* =========================
   HANDLE FORM SUBMISSION
========================= */
if (isset($_POST['add_department'])) {

    $title = mysqli_real_escape_string($conn, $_POST['department_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['department_description']);
    $stream_id = intval($_POST['stream']);

    // File Upload
    $pdf = $_FILES['syllabus']['name'];
    $tmp = $_FILES['syllabus']['tmp_name'];

    $ext = strtolower(pathinfo($pdf, PATHINFO_EXTENSION));

    if ($ext != "pdf") {
        echo "<script>alert('Only PDF files allowed');</script>";
    } else {

        // Unique file name
        $newName = time() . "_" . $pdf;
        $target = "../assets/syllabus/" . $newName;

        if (move_uploaded_file($tmp, $target)) {

            $query = "INSERT INTO department 
            (department_name, department_description, syllabus, Honours) 
            VALUES ('$title', '$desc', '$newName', $stream_id)";

            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('$title department added successfully');</script>";
            } else {
                echo "<script>alert('Error adding department');</script>";
            }
        } else {
            echo "<script>alert('File upload failed');</script>";
        }
    }
}
?>
<div class="card">
    <h3>➕ Add Department</h3>

    <form method="POST" action="" enctype="multipart/form-data">

        <input type="text" name="department_title" placeholder="Department title" required>

        <textarea name="department_description" placeholder="Department description"></textarea>

        <select name="stream" required>
            <option value="">Select Stream</option>

            <?php
            $stmnt = "SELECT * FROM Honours";
            $result = mysqli_query($conn, $stmnt);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['honours_id'];
                $hname = $row['honours_name'];

                echo "<option value='$id'>$hname</option>";
            }
            ?>
        </select>

        <label>
            Upload Syllabus
            <input type="file" name="syllabus" required>
        </label>

        <button type="submit" name="add_department">Add Department</button>

    </form>
</div>