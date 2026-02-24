<?php
require_once "../includes/db.php";

if (isset($_POST['add_faculty'])) {

    // =========================
    // SANITIZE INPUT
    // =========================
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $department = (int)$_POST['department'];
    $qualification = $_POST['qualification'];
    $joining = (int)$_POST['joining'];
    $designation = $_POST['designation'];
    $experience = (int)$_POST['experience'];
    $address = trim($_POST['address']);

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $fname . " " . $lname;

    // =========================
    // CHECK DUPLICATE EMAIL
    // =========================
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists');</script>";
        exit;
    }

    // =========================
    // IMAGE UPLOAD
    // =========================
    $newImage = NULL;

    if (!empty($_FILES['image']['name'])) {

        $imageName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];

        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            echo "<script>alert('Only JPG, JPEG, PNG allowed');</script>";
            exit;
        }

        if ($size > 2 * 1024 * 1024) { // 2MB
            echo "<script>alert('File too large (Max 2MB)');</script>";
            exit;
        }

        $newImage = uniqid() . "." . $ext;
        $target = "../assets/images/faculty/" . $newImage;

        if (!move_uploaded_file($tmp, $target)) {
            echo "<script>alert('Image upload failed');</script>";
            exit;
        }
    }

    // =========================
    // TRANSACTION START
    // =========================
    $conn->begin_transaction();

    try {

        // =========================
        // INSERT USER
        // =========================
        $user_stmt = $conn->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)"
        );

        $role = "faculty";
        $user_stmt->bind_param("ssss", $full_name, $email, $password, $role);
        $user_stmt->execute();

        // GET INSERTED ID
        $user_id = $conn->insert_id;

        // CREATE FACULTY CODE
        $fcode = "FAC" . $user_id;

        // =========================
        // INSERT FACULTY
        // =========================
        $stmt = $conn->prepare(
            "INSERT INTO faculty 
            (faculty_code, first_name, last_name, email, phone, gender, department_id, joining_year, 
            qualification, designation, experience_years, address, photo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssssiississ",
            $fcode,
            $fname,
            $lname,
            $email,
            $phone,
            $gender,
            $department,
            $joining,
            $qualification,
            $designation,
            $experience,
            $address,
            $newImage
        );

        $stmt->execute();

        // =========================
        // COMMIT
        // =========================
        $conn->commit();

        echo "<script>alert('Faculty added successfully');</script>";
    } catch (Exception $e) {

        // ROLLBACK
        $conn->rollback();

        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="card">
    <h3>➕Add Faculty</h3>
    <form method="POST" action="" enctype="multipart/form-data">

        <input type="text" name="first_name" placeholder="First name" required>
        <input type="text" name="last_name" placeholder="Last name" required>

        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>

        <div>
            <label><input type="radio" value="male" name="gender" required> Male</label>
            <label><input type="radio" value="female" name="gender"> Female</label>
        </div>

        <select name="qualification" id="">
            <option value="">Qualification</option>
            <option value="Post Graduate">Post Graduate</option>
            <option value="Doctorate(Phd.)">Doctorate(Phd.)</option>
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
        <input type="number" name="joining" min="2000" max="2026" placeholder="year of Joining ">

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

<div class="card">

</div>