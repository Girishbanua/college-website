<?php require_once "../includes/db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <style>
        body {
            padding: 20px;
        }

        .department_container {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 30px 0;
        }

        /* Card Container */
        .container {
            width: 400px;
            padding: 40px;

            /* Glass Effect */
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            backdrop-filter: blur(12px);
            box-shadow: -14px 10px 31px -14px rgba(0, 0, 0, 0.3);
            text-align: center;
            border: 1px solid #2563eb1c;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 20px;

            /* Gradient Text */
            background: linear-gradient(to right, #00c6ff, #0072ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dept-box {
            margin-top: 20px;
            padding: 20px;
            border-radius: 12px;

            background: rgba(255, 255, 255, 0.1);
            transition: 0.3s;
        }

        .dept-box:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.2);
        }

        .dept-name {
            font-size: 22px;
            font-weight: 500;
        }

        /* Back Button */
        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            transition: 0.3s;
        }

        .back-btn:hover {
            opacity: 0.8;
        }

        /* Mobile */
        @media(max-width: 500px) {
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <a href="javascript:history.back()" class="back-btn">← Go Back</a>
    <div class="department_container">
        <?php
        $id = $_GET['id'];

        $stmnt = "SELECT * FROM department WHERE Honours = $id";
        $result = mysqli_query($conn, $stmnt);

        while ($row = mysqli_fetch_assoc($result)) {
            $dept = $row['department_name'];
            $desc = $row['department_description'];

            echo " <div class='container'> <h1>Department of $dept</h1>
             <div class='dept-box'>
             <p class='dept-name'>$desc</p>
             </div> 
             </div>";
        }
        ?>

    </div>

</body>

</html>