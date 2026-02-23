<?php
require_once "../includes/db.php";

if (isset($_POST['upload'])) {
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "../assets/images/" . $image);

    mysqli_query($conn, "INSERT INTO slider_images (image) VALUES ('$image')");

    header("Location: dashboard.php");
}
?>

<div class="card">
    <h3>Homepage Slider </h3>
    <!-- Upload Form -->
    <form action="slider.php" method="POST" enctype="multipart/form-data" style="margin-bottom:20px;">
        <input type="file" name="image" required>
        <button type="submit" name="upload">Upload Image</button>
    </form>
</div>
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