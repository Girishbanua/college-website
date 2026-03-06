<?php
require_once "../includes/db.php";
if ($_SESSION['role'] != 'admin') die("Access denied");

if (isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // $query = "INSERT INTO news (title, content) VALUES ('$title', '$content')";
    // mysqli_query($conn, $query);

    // header("Location: dashboard.php");
}
?>
<div class="card">
    <h3>📰 Post News/Notice</h3>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="News title" required>
        <textarea name="content" placeholder="News content" required></textarea>
        <button type="submit" name="add_news">Post</button>
    </form>
</div>

<!-- News List -->
<div class="card">
    <h3>📰 Latest News</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($n = mysqli_fetch_assoc($news)) { ?>
                <tr>
                    <td style="width: 80px;"><?= date('d-m-y', strtotime($n['created_at'])) ?></td>
                    <td style="width: 150px;"><?= $n['title'] ?></td>
                    <td style="width: 560px;"><?= $n['content'] ?></td>
                    <td>
                        <button class="btn danger" onclick="return confirm('Delete this news?')">Delete</button>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>


</div>