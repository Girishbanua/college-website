<?php
include "./includes/db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VDC | Home</title>
    <link rel="icon" type="image/png" href="./assets/images/favicon.jpg">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/highlights.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/courses.css">
    <link rel="stylesheet" href="assets/css/message.css">
    <link rel="stylesheet" href="assets/css/success_section.css">
    <style>
        /* Dropdown */
        li {
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 20px;
            left: -15px;
            background: #ffff;
            backdrop-filter: blur(20px);
            min-width: 180px;
            border-radius: 4px;
            padding: 10px;
        }

        .dropdown-menu li {
            padding: 5px;
            border-radius: 5px;
        }

        .dropdown-menu li a {
            padding: 10px 15px;
            font-size: 13px;
        }

        .dropdown-menu li a:hover {
            color: white;
        }

        .dropdown-menu li:hover {
            background-color: #3b8abbff;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="./assets/images/logo.png" alt="logo" style="width: 200px;">
        </div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li class="dropdown"><a href="#about">Academics</a>
                <ul class="dropdown-menu">
                    <?php
                    $stmnt = mysqli_query($conn, "SELECT * FROM department");
                    while ($row = mysqli_fetch_assoc($stmnt)) {
                        $dept = $row['department_name'];
                        $id = $row['department_id'];
                        echo "<li><a href='pages/department_details.php?dept_id=$id'>$dept</a></li>";
                    };

                    ?>

                </ul>
            </li>
            <li><a href="#courses">Courses</a></li>
            <li><a href="./pages/Gallery.php">Gallery</a></li>
            <li><a href="#news">News</a></li>
            <li><a href="./pages/contact.php">Contact</a></li>
            <li><a href="./login.php">Faculty</a></li>
        </ul>
        <a href="login.php" class="btn">Get Started</a>
    </nav>
    <!-- Hero Section -->
    <!-- <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Vedic Degree College</h1>
            <p>Your one-stop platform for courses, results, notes, and campus updates.</p>
            <div class="hero-buttons">
                <a href="login.php" class="primary-btn">Get Started</a>
                <a href="register.php" class="secondary-btn">Register</a>
            </div>
        </div>
    </section> -->
    <div class="video-container">
        <video autoplay muted loop playsinline id="bg-video">
            <source src="./assets/videos/vedic_video.mp4" type="video/mp4">
        </video>

        <div class="content">
            <h1>Welcome to Our College</h1>
            <p>Explore Excellence</p>
        </div>
    </div>
    <!-- News -->
    <section id="news" class="section">
        <h2>Latest News & Notices</h2>
        <ul class="news-list">
            <?php
            require_once "includes/db.php";
            $result = mysqli_query($conn, "SELECT * FROM news ORDER BY created_at DESC LIMIT 5");

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li><strong>{$row['title']}</strong> - {$row['content']}</li>";
            }
            ?>
        </ul>
    </section>

    <div class="success-section">

        <!-- Header -->
        <div class="courses-header">
            <span class="section-line"></span>
            <h1>Our Success Stories</h1>
        </div>

        <!-- Cards -->
        <section class="featured">

            <div class="card">
                <img src="assets/images/Gm1.jpg" alt="">
                <div class="card-content">
                    <h3>GM Sustainable</h3>
                    <a href="#">Learn More</a>
                </div>
            </div>

            <div class="card">
                <img src="assets/images/treeplantation.jpg" alt="">
                <div class="card-content">
                    <h3>Tree Plantation Drive</h3>
                    <a href="#">Learn More</a>
                </div>
            </div>

            <div class="card">
                <img src="assets/images/food fest banner.jpg" alt="">
                <div class="card-content">
                    <h3>Food Fest 2025</h3>
                    <a href="#">Learn More</a>
                </div>
            </div>

            <div class="card">
                <img src="assets/images/Vijostav.jpg" alt="">
                <div class="card-content">
                    <h3>Vijostav</h3>
                    <a href="#">Learn More</a>
                </div>
            </div>

        </section>

    </div>

    <?php
    include "./components/Highlight.php";
    ?>
    <section id="courses">
        <?php include "./pages/courses.php"; ?>
    </section>

    <section class="academics-section">
        <div class="container">

            <!-- Header -->
            <div class="header">
                <h1>Academics</h1>
                <p>
                    Undergraduate education at
                    <span class="highlight">Vedic Degree College</span>
                    focuses on strong fundamentals, practical learning, and holistic development.
                </p>
            </div>

            <!-- Academic Philosophy -->
            <div class="card">
                <h2>Our Academic Philosophy</h2>
                <p>
                    At <span class="highlight">Vedic Degree College</span>, our undergraduate programs are designed to build conceptual clarity,
                    analytical thinking, and real-world skills. We aim to prepare students for higher studies, competitive examinations,
                    and successful careers.
                </p>
            </div>

            <!-- Teaching & Evaluation -->
            <div class="two-col">
                <div class="card">
                    <h4>Teaching Methodology</h4>
                    <ul>
                        <li>Outcome-based undergraduate curriculum</li>
                        <li>Interactive classroom teaching</li>
                        <li>Practical laboratory sessions</li>
                        <li>Project-based learning</li>
                        <li>Digital learning resources</li>
                    </ul>
                </div>

                <div class="card">
                    <h4>Evaluation System</h4>
                    <ul>
                        <li>Semester-based exams</li>
                        <li>Internal assessments</li>
                        <li>Continuous evaluation</li>
                        <li>University norms</li>
                    </ul>
                </div>
            </div>

            <!-- Academic Support -->
            <div class="card">
                <h3>Academic Support & Resources</h3>
                <ul class="support">
                    <li>Well-equipped library</li>
                    <li>Faculty mentorship</li>
                    <li>Remedial courses</li>
                    <li>Career guidance</li>
                </ul>
            </div>

            <!-- CTA -->
            <div class="cta">
                <h3>Build Your Foundation with Us</h3>
                <p>
                    Choose from our undergraduate programs and take the first step toward a successful academic journey.
                </p>
                <button>View Programs</button>
            </div>

        </div>
    </section>


    <!-- Image Slider -->
    <div class="slider">
        <div class="slides">
            <?php
            require_once "includes/db.php";
            $images = mysqli_query($conn, "SELECT * FROM slider_images ORDER BY created_at DESC LIMIT 5");
            $first = true;

            while ($img = mysqli_fetch_assoc($images)) {
                $active = $first ? "active" : "";
                echo "<img src='assets/images/{$img['image']}' class='slide $active'>";
                $first = false;
            }
            ?>
        </div>

        <button class="prev" onclick="prevSlide()">❮</button>
        <button class="next" onclick="nextSlide()">❯</button>
    </div>

    <!-- About -->
    <section id="about" class="section">
        <h2>About Our College</h2>
        <p>
            We are committed to providing quality education and a supportive learning environment.
            This portal helps students, faculty, and administrators stay connected digitally.
        </p>
    </section>
    <img src="assets/images/chairman sir.jpg" alt="" style="object-fit: cover; width: 100%;" />
    <section class="message-section">
        <div class="container">

            <!-- Heading -->
            <div class="section-header">
                <h2>Leadership Messages</h2>
                <p>Guiding words from our leadership for students and the community.</p>
            </div>

            <div class="message-grid">

                <!-- Chairman Message -->
                <div class="message-card">
                    <div class="message-image">
                        <img src="assets/images/chairman sir.jpg" alt="Chairman">
                    </div>
                    <div class="message-content">
                        <h3>Chairman's Message</h3>
                        <p>
                            Welcome to <span class="highlight">Vedic Degree College</span>. Our vision is to provide
                            quality education that nurtures knowledge, values, and skills.
                            We are committed to creating an environment that empowers students
                            to grow academically and personally, preparing them to meet future challenges.
                        </p>
                        <h4>Shri. Anand Agarwal</h4>
                        <span>Chairman</span>
                    </div>
                </div>

                <!-- Principal Message -->
                <div class="message-card">
                    <div class="message-image">
                        <img src="assets/images/faculti/Principal.png" alt="Principal">
                    </div>
                    <div class="message-content">
                        <h3>Principal's Message</h3>
                        <p>
                            At <span class="highlight">Vedic Degree College</span>, we focus on holistic development
                            through academic excellence, discipline, and innovation.
                            Our dedicated faculty and modern infrastructure help students
                            achieve their goals and become responsible citizens of society.
                        </p>
                        <h4>Dr. Sweta Mishra</h4>
                        <span>Principal</span>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <?php
    include "./pages/contact.php";
    ?>

</body>
<!-- Footer -->
<footer class="college-footer">
    <div class="footer-top">
        <!-- COLLEGE INFO -->
        <div class="footer-col">
            <img
                src="./assets/images/logo.png"
                alt="College Logo"
                class="footer-logo" />

            <p>
                Vedic Degree College has adapted and accepted the implementation of
                modern systems, adopting latest technologies in teaching
                methodologies and developments making education a truly global.
            </p>
        </div>

        <!-- CONTACT -->
        <div class="footer-col">
            <h4>Get In Touch</h4>

            <div class="contact-item">
                📍 Vedic Degree College
                <br />
                Pabpali Sason, Sambalpur
            </div>

            <div class="contact-item">📞 +91 93373 10441</div>
            <div class="contact-item">📞 +91 90933 56789</div>

            <div class="social-icons">
                <a href="#">f</a>
                <a href="#">i</a>
                <a href="#">▶</a>
                <a href="#">in</a>
            </div>
        </div>

        <!-- QUICK LINKS -->
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li>
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">Leadership</a>
                </li>
                <li>
                    <a href="#">Milestone</a>
                </li>
                <li>
                    <a href="#">Registration</a>
                </li>
                <li>
                    <a href="#">Contact Us</a>
                </li>
            </ul>
        </div>

        <!-- USEFUL LINKS -->
        <div class="footer-col">
            <h4>Useful Links</h4>
            <ul>
                <li>
                    <a target="_blank" href="https://nta.ac.in/">
                        NTA
                    </a>
                </li>
                <li>
                    <a target="_blank" href="https://www.aicte.gov.in/">
                        AICTE
                    </a>
                </li>
                <li>
                    <a target="_blank" href="https://www.ugc.gov.in/">
                        UGC
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- FOOTER BOTTOM -->
    <div class="footer-bottom text-center">
        <p class="text-center">
            © 2026 Vedic Degree College. Designed and Maintained by the Department
            of BCA.
        </p>
    </div>
</footer>
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove("active"));
        slides[index].classList.add("active");
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    // Auto slide every 4 seconds
    setInterval(nextSlide, 5000);
</script>

</html>