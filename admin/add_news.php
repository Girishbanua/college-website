<?php
require_once "../includes/db.php";

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