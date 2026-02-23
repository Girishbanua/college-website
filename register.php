<?php
require_once "includes/db.php";

$success = "";
$error = "";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $batch = intval($_POST['batch']);
    $department = $_POST['department'];
    $semester = (int)$_POST['semester'];
    $roll = trim($_POST['roll_number']);
    $password = $_POST['password'];


    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required!";
    } else {
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // inserting in users table
            $user_query = "INSERT INTO users (name, email, password)
                      VALUES ('$name', '$email', '$hashedPassword')";
            // inserting in students table
            $student_query = "INSERT INTO students (student_name, email, department_id, roll_number, semester)
                      VALUES ('$name', '$email', $department, '$roll', $semester)";

            if (mysqli_query($conn, $user_query)) {
                if (mysqli_query($conn, $student_query))
                    $success = "Registration successful! You can now login.";
                else
                    $error = "Registration failed!!";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register | College Portal</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <div class="login-container">
        <h2>Create Account</h2>

        <?php if ($error) { ?>
            <p style="color:red; text-align:center;"><?= $error ?></p>
        <?php } ?>

        <?php if ($success) { ?>
            <p style="color:green; text-align:center;"><?= $success ?></p>
        <?php } ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter email ID" required>
            </div>
            <div class="form-group">
                <div>
                    <label>Batch</label>
                    <select name="batch" style="padding: 5px;">
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                </div>

                <div>
                    <label>Department</label>
                    <select name="department" style="padding: 5px;">
                        <option value="">select department</option>
                        <?php
                        $stmnt = "SELECT * FROM department";
                        $result = mysqli_query($conn, $stmnt);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $dept = $row['department_name'];
                            $id = $row['department_id'];
                            echo "<option value='$id'>$dept</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label>Semester</label>
                    <select name="semester" style="padding: 5px;">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Roll number</label>
                <input type="text" name="roll_number"
                    placeholder="Enter rollnumber/registration ID" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Set password" required>
            </div>

            <button type="submit" name="register">Register</button>

            <p class="register-link">
                Already have an account? <a href="login.php">Login</a>
            </p>
        </form>
    </div>

</body>

</html>