<?php
require_once "../includes/db.php";
// if ($_SESSION['role'] != 'admin') die("Access denied");

if (isset($_POST['add_course'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    mysqli_query($conn, "INSERT INTO courses (title, description) VALUES ('$title', '$desc')");
}

?>

<div class="card">
    <h3>➕ Add Course</h3>
    <form method="POST" action="">
        <select name="" id="">
            <option value="">Department</option>
            <?php
            $stmnt = "Select * from department";
            $result = mysqli_query($conn, $stmnt);
            while ($row = mysqli_fetch_assoc($result)) {
                $dname = $row['department_name'];
                echo "<option value='$dname'>$dname</option>";
            }
            ?>
        </select>
        <input type="text" name="title" placeholder="Course title" required>
        <textarea name="description" placeholder="Course description"></textarea>
        <button type="submit" name="add_course">Add Course</button>
    </form>
</div>