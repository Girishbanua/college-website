<?php
session_start();
require_once "includes/db.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $uid = $user['id'];
        $_SESSION['role'] = $user['role'];
        $message = "";
        if ($user['role'] == 'student') {
            header("Location: student/");
        } elseif ($user['role'] == 'faculty') {
            header("Location: faculty?$uid");
        } elseif ($user['role'] == 'admin') {
            header("Location: admin/");
        }
        exit();
    } else {
        $message = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <!-- <?php echo "<p style='color: red;'>$message </p>" ?> -->
            <?php if (isset($message)) { ?>
                <p style="color:red; text-align:center;"><?= $message ?></p>
            <?php } ?>
            <button type="submit" name="login">Login</button>

            <p class="register-link">
                Don’t have an account? <a href="register.php">Register</a>
            </p>
        </form>
    </div>

</body>



</html>