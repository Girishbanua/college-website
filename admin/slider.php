<?php
require_once "../includes/db.php";
//require_once "../includes/auth_check.php"; // ensure admin only

// Upload Image
if (isset($_POST['upload'])) {
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $target = "../assets/images/" . $image;
    move_uploaded_file($tmp, $target);

    mysqli_query($conn, "INSERT INTO slider_images (image) VALUES ('$image')");
}

// Delete Image
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $res = mysqli_query($conn, "SELECT image FROM slider_images WHERE id = $id");
    $row = mysqli_fetch_assoc($res);

    unlink("../assets/images/" . $row['image']);
    mysqli_query($conn, "DELETE FROM slider_images WHERE id = $id");

    header("Location: slider.php");
}
