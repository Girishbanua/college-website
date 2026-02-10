<?php
require_once "../includes/db.php";

if (isset($_POST['upload'])) {
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "../assets/images/" . $image);

    mysqli_query($conn, "INSERT INTO slider_images (image) VALUES ('$image')");

    header("Location: dashboard.php");
}
