<?php
require_once "../includes/db.php";

$result = mysqli_query($conn, "SELECT * FROM questions");
$sid = filter_input(INPUT_GET, 'sid', FILTER_VALIDATE_INT);
$sem = filter_input(INPUT_GET, 'sem', FILTER_VALIDATE_INT);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <style>
        body {
            background: #f4f6f9;
            padding: 20px;
        }

        .quiz-box {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .question {
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            color: white;
            border: none;
            cursor: pointer;
        }

        .welcome {
            height: 200px;
            transition: all ease-in-out 0.5s;
        }

        .hidden {
            display: none;
            height: 0;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease;
        }
    </style>
</head>

<body>
    <!-- <div class="card" id="welcome">
        <p>welcome to Quiz Section</p>
    </div> -->
    <nav class="card" style="display: flex; align-items: center; justify-content: space-between;">
        <img src="../assets/images/logo.png" alt="Vedic Degree College" style="width: 200px;">
        <div style="text-align: center;">
            <h2>BCA</h2>
            <h3>Semester <?= $sem ?></h3>
            <p>Paper: Web Technologies</p>
        </div>
        <button class="btn">Quit</button>
    </nav>
    <div class="quiz-box">

        <h2>Quiz</h2>

        <form action="submit_quiz.php" method="POST">
            <?php $i = 1;
            while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="question">
                    <p><b><?php echo $i++; ?>. <?php echo $row['question']; ?></b></p>

                    <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="1" required> <?php echo $row['option1']; ?><br>
                    <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="2"> <?php echo $row['option2']; ?><br>
                    <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="3"> <?php echo $row['option3']; ?><br>
                    <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="4"> <?php echo $row['option4']; ?><br>
                </div>

            <?php } ?>

            <button class="btn">Submit Quiz</button>
        </form>
    </div>

</body>
<script>
    let welcome_box = document.getElementById("welcome");
    setTimeout(() => {
        welcome_box.classList.add("fade-out");
        setTimeout(() => {
            welcome_box.classList.add("hidden");
        }, 500)
    }, 3000);
</script>

</html>