<?php
require_once "../includes/db.php";

if (isset($_POST['add_faculty'])) {

    // Sanitize input
    $fname = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lname = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $joining = $_POST['joining'];
    $designation = $_POST['designation'];
    $experience = $_POST['experience'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Password hash 🔒
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    /* =========================
       IMAGE UPLOAD
    ========================= */
    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if (!empty($imageName)) {

        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {

            $newImage = time() . "_" . $imageName;
            $target = "../assets/images/faculty/" . $newImage;

            move_uploaded_file($tmp, $target);
        } else {
            echo "<script>alert('Only JPG, PNG allowed');</script>";
            exit;
        }
    } else {
        $newImage = NULL;
    }

    /* =========================
       INSERT INTO DATABASE
    ========================= */
    $stmt = $conn->prepare("INSERT INTO faculty 
    (first_name, last_name, email, phone, gender, department_id, joining_year, designation, experience_years, address, photo) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {

        $stmt->bind_param(
            "ssssssissss",
            $fname,
            $lname,
            $email,
            $phone,
            $gender,
            $department,
            $joining,
            $designation,
            $experience,
            $address,
            $newImage,
        );

        if ($stmt->execute()) {

            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Faculty added successfully');</script>";
            } else {
                echo "<script>alert('Insert failed');</script>";
            }
        } else {
            echo "Execute Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Prepare Error: " . $conn->error;
    }
}
?>

<div class="card">
    <h3>➕Add Faculty</h3>
    <form method="POST" action="" enctype="multipart/form-data">

        <input type="text" name="first_name" placeholder="First name" required>
        <input type="text" name="last_name" placeholder="Last name" required>

        <input type="email" name="email" placeholder="Email" required>
        <input type="number" name="phone" placeholder="Phone Number" required>

        <div>
            <label><input type="radio" value="male" name="gender" required> Male</label>
            <label><input type="radio" value="female" name="gender"> Female</label>
        </div>

        <select name="" id="">
            <option value="">Qualification</option>
            <option value="">Post Graduate</option>
            <option value="">Doctorate(Phd.)</option>
        </select>

        <select name="department" required>
            <option value="">Select department</option>
            <?php
            $stmnt = "SELECT * FROM department";
            $result = mysqli_query($conn, $stmnt);

            while ($row = mysqli_fetch_assoc($result)) {
                $dept_name = $row['department_name'];
                $dept_id = $row['department_id'];
                echo "<option value='$dept_id'>$dept_name</option>";
            }
            ?>
        </select>

        <small>Joining year</small>
        <input type="number" name="joining" placeholder="Joining year">

        <select name="designation">
            <option value="">Designation</option>
            <option value="Lecturer">Lecturer</option>
            <option value="Assistant Professor">Assistant Professor</option>
        </select>

        <input type="number" name="experience" placeholder="Experience in years">
        <input type="text" name="address" placeholder="Address">

        <small>Profile Image</small>
        <input type="file" name="image">

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="add_faculty">Create User</button>

    </form>
</div>