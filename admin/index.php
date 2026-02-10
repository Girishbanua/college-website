<?php
session_start();
require_once "../includes/db.php";

// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

// Fetch users
$users = mysqli_query($conn, "SELECT id, name, email, role FROM users");

// Fetch courses
$courses = mysqli_query($conn, "SELECT * FROM courses");

// Fetch news (create table if not exists)
mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )
");
$news = mysqli_query($conn, "SELECT * FROM news ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <div class="header">
        <h2>Admin Panel</h2>
        <a href="../logout.php" class="logout">Logout</a>
    </div>
    <main>
        <aside>
            <h2>Add users</h2>
            <h2>Add students</h2>
            <h2>Add news</h2>
            <h2>Home Page Slider</h2>
        </aside>

        <div class="container">

            <div class="grid">

                <!-- Add Course -->
                <div class="card">
                    <h3>➕ Add Course</h3>
                    <form method="POST" action="add_course.php">
                        <input type="text" name="title" placeholder="Course title" required>
                        <textarea name="description" placeholder="Course description"></textarea>
                        <button type="submit" name="add_course">Add Course</button>
                    </form>
                </div>

                <!-- Add User -->
                <div class="card">
                    <h3>➕ Add User</h3>
                    <form method="POST" action="add_user.php">
                        <input type="text" name="name" placeholder="Full name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <select name="role" required>
                            <option value="">Select role</option>
                            <option value="student">Student</option>
                            <option value="faculty">Faculty</option>
                            <option value="admin">Admin</option>
                        </select>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" name="add_user">Create User</button>
                    </form>
                </div>

                <!-- Post News -->
                <div class="card">
                    <h3>📰 Post News/Notice</h3>
                    <form method="POST" action="add_news.php">
                        <input type="text" name="title" placeholder="News title" required>
                        <textarea name="content" placeholder="News content" required></textarea>
                        <button type="submit" name="add_news">Post</button>
                    </form>
                </div>

                <h2>Homepage Slider Management</h2>

                <!-- Upload Form -->
                <form action="slider.php" method="POST" enctype="multipart/form-data" style="margin-bottom:20px;">
                    <input type="file" name="image" required>
                    <button type="submit" name="upload">Upload Image</button>
                </form>

                <hr>

                <!-- Display Uploaded Images -->
                <div style="display:flex; gap:20px; flex-wrap:wrap;">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM slider_images ORDER BY created_at DESC");
                    while ($img = mysqli_fetch_assoc($result)) {
                    ?>
                        <div style="border:1px solid #ccc; padding:10px; text-align:center;">
                            <img src="../assets/images/<?= $img['image'] ?>" width="180" height="100" style="object-fit:cover;"><br><br>
                            <a href="slider.php?delete=<?= $img['id'] ?>" onclick="return confirm('Delete this image?')" style="color:red;">Delete</a>
                        </div>
                    <?php } ?>
                </div>

            </div>

            <br>

            <!-- Users List -->
            <div class="card">
                <h3>👥 Users</h3>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($u = mysqli_fetch_assoc($users)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($u['name']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['role']) ?></td>
                            <td>
                                <a class="btn danger" href="delete_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <!-- Courses List -->
            <div class="card">
                <h3>📚 Courses</h3>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($c = mysqli_fetch_assoc($courses)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($c['title']) ?></td>
                            <td><?= htmlspecialchars($c['description']) ?></td>
                            <td>
                                <a class="btn danger" href="delete_course.php?id=<?= $c['id'] ?>" onclick="return confirm('Delete course?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <!-- News List -->
            <div class="card">
                <h3>📰 Latest News</h3>
                <ul>
                    <?php while ($n = mysqli_fetch_assoc($news)) { ?>
                        <li><strong><?= htmlspecialchars($n['title']) ?></strong> – <?= htmlspecialchars($n['content']) ?></li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </main>
</body>

</html>