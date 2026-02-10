<?php
require_once "../includes/db.php";

if (isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "INSERT INTO news (title, content) VALUES ('$title', '$content')";
    mysqli_query($conn, $query);

    header("Location: dashboard.php");
}
?>

<h2>Add News / Notice</h2>

<form method="POST">
    <input type="text" name="title" placeholder="News Title" required><br><br>
    <textarea name="content" placeholder="News Content"></textarea><br><br>
    <button type="submit" name="add_news">Publish</button>
</form>