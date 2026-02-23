<?php
include "../includes/db.php";

$id = $_GET['dept_id'];
$stmnt = mysqli_query($conn, "SELECT * from department where department_id = $id");
$row = mysqli_fetch_assoc($stmnt);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department of Computer Science</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f7fa;
    }

    /* HEADER */
    .header {
        background: linear-gradient(to right, #004aad, #007bff);
        color: white;
        text-align: center;
        padding: 40px 20px;
    }

    /* SECTIONS */
    section {
        padding: 40px 20px;
        max-width: 1000px;
        margin: auto;
    }

    h2 {
        color: #004aad;
        margin-bottom: 15px;
    }

    /* VISION & MISSION */
    .vision-mission {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .vision-mission div {
        flex: 1;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    /* CURRICULUM */
    .curriculum ul {
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    /* FACULTY */
    .faculty-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .card {
        background: white;
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        transition: 0.3s;
    }

    .card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
    }

    .card:hover {
        transform: scale(1.05);
    }

    /* LIST STYLING */
    ul {
        list-style: none;
        padding-left: 0;
    }

    ul li {
        padding: 8px 0;
    }

    /* CONTACT */
    .contact {
        text-align: center;
    }

    /* FOOTER */
    footer {
        text-align: center;
        background: #222;
        color: white;
        padding: 15px;
    }
</style>

<body>

    <!-- HEADER -->
    <header class="header">
        <h1><?= $row['department_description'] ?></h1>
        <!-- <p>Empowering Innovation through Technology</p> -->
    </header>

    <!-- ABOUT -->
    <section class="about">
        <h2>About the Department</h2>
        <p>
            <?= $row['about'] ?>
        </p>
    </section>

    <!-- VISION & MISSION -->
    <section class="vision-mission">
        <div>
            <h2>Vision</h2>
            <p>To become a center of excellence in computer science education and research.</p>
        </div>
        <div>
            <h2>Mission</h2>
            <ul>
                <li>Provide quality technical education</li>
                <li>Encourage innovation and research</li>
                <li>Develop industry-ready professionals</li>
            </ul>
        </div>
    </section>

    <!-- CURRICULUM -->
    <section class="curriculum">
        <h2>Curriculum</h2>
        <ul>
            <li>Data Structures & Algorithms</li>
            <li>Database Management Systems</li>
            <li>Operating Systems</li>
            <li>Computer Networks</li>
            <li>Web Development</li>
            <li>Cloud Computing</li>
            <li>Artificial Intelligence</li>
        </ul>
    </section>

    <!-- FACULTY -->
    <section class="faculty">
        <h2>Our Faculty</h2>

        <div class="faculty-grid">
            <div class="card">
                <img src="images/faculty1.jpg" alt="">
                <h3>Dr. A. Sharma</h3>
                <p>Head of Department</p>
            </div>

            <div class="card">
                <img src="images/faculty2.jpg" alt="">
                <h3>Mr. B. Kumar</h3>
                <p>Assistant Professor</p>
            </div>

            <div class="card">
                <img src="images/faculty3.jpg" alt="">
                <h3>Ms. C. Das</h3>
                <p>Lecturer</p>
            </div>
        </div>
    </section>

    <!-- FACILITIES -->
    <section class="facilities">
        <h2>Facilities</h2>
        <ul>
            <li>Modern Computer Labs</li>
            <li>High-Speed Internet</li>
            <li>Smart Classrooms</li>
            <li>Project Labs</li>
        </ul>
    </section>

    <!-- ACHIEVEMENTS -->
    <section class="achievements">
        <h2>Achievements</h2>
        <ul>
            <li>Top placements in IT companies</li>
            <li>Students won hackathon competitions</li>
            <li>Research publications in journals</li>
        </ul>
    </section>

    <!-- CONTACT -->
    <section class="contact">
        <h2>Contact Us</h2>
        <p>Email: cs@college.edu</p>
        <p>Phone: +91 9876543210</p>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>© 2026 College Name | Department of Computer Science</p>
    </footer>

</body>

</html>