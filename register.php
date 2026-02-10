<?php
require_once "includes/db.php";

$success = "";
$error = "";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // student or faculty

    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required!";
    } else {
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (name, email, password, role)
                      VALUES ('$name', '$email', '$hashedPassword', '$role')";

            if (mysqli_query($conn, $query)) {
                $success = "Registration successful! You can now login.";
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
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Register As</label>
                <select name="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="student">Student</option>
                    <option value="faculty">Faculty</option>
                </select>
            </div>

            <button type="submit" name="register">Register</button>

            <p class="register-link">
                Already have an account? <a href="login.php">Login</a>
            </p>
        </form>
    </div>

</body>

</html>