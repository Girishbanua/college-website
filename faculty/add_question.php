<?php
require_once "../includes/db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct = $_POST['correct_option'];
    $sem = $_POST['semester'];
    $dept = $_POST['dept_id'];
    $course = $_POST['course'];

    // Prepared statement (secure)
    $stmt = $conn->prepare("INSERT INTO questions VALUES (?, ?, ?, ?, ?, ?,?,?,?)");
    $stmt->bind_param("sssssi", $question, $option1, $option2, $option3, $option4, $correct, $sem, $dept, $course);

    if ($stmt->execute()) {
        $msg = "Question added successfully!";
    } else {
        $msg = "Error adding question!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Question</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .hide {
        display: none;
    }
</style>

<body>

    <div class="container">

        <?php if ($msg != "") { ?>
            <div id="alertBox" class="alert success"
                style="padding:30px; border-radius:20px;">
                <?php echo $msg; ?>
            </div>
        <?php } ?>

        <form method="POST">
            <label for="semester">Select Semester</label>
            <select name="semester" id="semester" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
            <label for="course">Select Course</label>
            <select name="course" id="" required>
                <option value="CC201">Botany</option>
            </select>
            <textarea name="question" placeholder="Enter question" required></textarea>

            <input type="text" name="option1" placeholder="Option 1" required>
            <input type="text" name="option2" placeholder="Option 2" required>
            <input type="text" name="option3" placeholder="Option 3" required>
            <input type="text" name="option4" placeholder="Option 4" required>

            <label>Correct Option</label>
            <select name="correct_option" required>
                <option value="">Select</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>
            </select>

            <button type="submit">Add Question</button>
        </form>

    </div>

    <script>
        let alertBox = document.getElementById("alertBox");

        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.add("hide");
            }, 3000);
        }
    </script>

</body>

</html>