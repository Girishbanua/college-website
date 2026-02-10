<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>College Portal | Welcome</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/highlights.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/courses.css">
    <link rel="stylesheet" href="assets/css/galleri.css">
</head>

<body>

    <!-- Navbar -->
    <?php include "./components/navbar.php" ?>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Our College Portal</h1>
            <p>Your one-stop platform for courses, results, notes, and campus updates.</p>
            <div class="hero-buttons">
                <a href="login.php" class="primary-btn">Get Started</a>
                <a href="register.php" class="secondary-btn">Register</a>
            </div>
        </div>
    </section>
    <!-- News -->
    <section id="news" class="section">
        <h2>Latest News & Notices</h2>
        <ul class="news-list">
            <?php
            require_once "includes/db.php";
            $result = mysqli_query($conn, "SELECT * FROM news ORDER BY created_at DESC LIMIT 5");

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>📢 <strong>{$row['title']}</strong> - {$row['content']}</li>";
            }
            ?>
        </ul>
    </section>

    <?php
    include "./components/Highlight.php";
    include "./pages/courses.php";
    ?>
    <!-- Courses -->


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



</body>
<!-- Footer -->
<footer class="college-footer">
    <div class="footer-top">
        <!-- COLLEGE INFO -->
        <div class="footer-col">
            <img
                src="./assets/images/Degree_logo_png.png"
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