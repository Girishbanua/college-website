<section class="courses-section" id="academics">
    <div class="courses-header">
        <span class="section-line"></span>
        <h2>Explore our academic programs across multiple disciplines.</h2>
    </div>

    <div class="courses-grid">
        <?php
        $stmnt = "SELECT * from honours";
        $result = mysqli_query($conn, $stmnt);

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['honours_id'];
            $honours = $row['honours_name'];
            $desc = $row['honours_description'];
            echo "
                
        <div class='course-card'>
            <h3> $honours </h3>
            <p>
                $desc                
            </p>
            <a href='pages/department.php?id=$id'>
                Learn More <span>→</span>
            </a>
        </div>
            ";
        }
        ?>
    </div>
</section>