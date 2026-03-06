<?php
require_once "../includes/db.php";

$answers = $_POST['answer'];
$marks = 0;
$total = count($answers);

foreach ($answers as $question_id => $selected_option) {

    $query = mysqli_query($conn, "SELECT correct_option FROM questions WHERE id=$question_id");
    $row = mysqli_fetch_assoc($query);

    if ($row['correct_option'] == $selected_option) {
        $marks++;
    }
}

// Example student id (use session in real project)
$student_id = $_SESSION['user_id'] ?? null;

// Save result
$query = "INSERT INTO results (student_id, marks, total_questions)
VALUES ($student_id, $marks, $total)";

$conn->prepare($query);


?>

<!DOCTYPE html>
<html>

<head>
    <title>Result</title>
</head>

<body>

    <h2>Your Score: <?php echo $marks; ?> / <?php echo $total; ?></h2>

    <a href="quiz.php">Try Again</a>

</body>

</html>