<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["user_id"];
$courseId = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
$score = 0;
$totalQuestions = 0;
$correctAnswers = [];

if ($courseId > 0) {
    // Fetch correct answers from the database
    $stmt = $conn->prepare("SELECT id, correct_option FROM questions WHERE course_id = ?");
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $correctAnswers[$row['id']] = $row['correct_option'];
    }
    $stmt->close();
    $totalQuestions = count($correctAnswers);

    // Calculate score
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'q') === 0) {
            $questionId = str_replace('q', '', $key);
            if (isset($correctAnswers[$questionId]) && $value === $correctAnswers[$questionId]) {
                $score++;
            }
        }
    }

    // Save the score to the user_progress table
    $stmt = $conn->prepare("REPLACE INTO user_progress (user_id, course_id, score) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $courseId, $score);
    $stmt->execute();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNOWWELL - Quiz Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="logo">KNOWWELL</span>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="courses.php">Courses</a>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></span>
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <main class="container">
        <h2>Your Results</h2>
        <?php if ($courseId > 0 && $totalQuestions > 0): ?>
            <p>You have successfully completed the quiz!</p>
            <p class="score-display">Your final score is: <?php echo $score; ?> out of <?php echo $totalQuestions; ?></p>
            <div class="auth-links">
                <a href="courses.php" class="cta-button">Go back to courses</a>
            </div>
        <?php else: ?>
            <p>There was an error processing your quiz. Please try again.</p>
        <?php endif; ?>
    </main>
</body>
</html>