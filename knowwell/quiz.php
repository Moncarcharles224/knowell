<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$courseId = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$courseName = "Quiz";
$questions = [];

if ($courseId > 0) {
    // Fetch course name
    $stmt = $conn->prepare("SELECT course_name FROM courses WHERE id = ?");
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $courseResult = $stmt->get_result();
    if ($row = $courseResult->fetch_assoc()) {
        $courseName = htmlspecialchars($row['course_name']);
    }
    $stmt->close();

    // Fetch quiz questions
    $stmt = $conn->prepare("SELECT id, question_text, option_a, option_b, option_c, option_d FROM questions WHERE course_id = ?");
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $questionsResult = $stmt->get_result();
    while ($row = $questionsResult->fetch_assoc()) {
        $questions[] = $row;
    }
    $stmt->close();
}

if (empty($questions)) {
    // If no questions are found, redirect back to the courses page
    header("Location: courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNOWWELL - <?php echo $courseName; ?> Quiz</title>
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
        <h2><?php echo $courseName; ?> Quiz</h2>
        <form action="submit_quiz.php" method="post">
            <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question-block">
                    <h3><?php echo $index + 1 . ". " . htmlspecialchars($question['question_text']); ?></h3>
                    <div class="options-list">
                        <label>
                            <input type="radio" name="q<?php echo $question['id']; ?>" value="a" required>
                            <?php echo htmlspecialchars($question['option_a']); ?>
                        </label>
                        <label>
                            <input type="radio" name="q<?php echo $question['id']; ?>" value="b">
                            <?php echo htmlspecialchars($question['option_b']); ?>
                        </label>
                        <label>
                            <input type="radio" name="q<?php echo $question['id']; ?>" value="c">
                            <?php echo htmlspecialchars($question['option_c']); ?>
                        </label>
                        <label>
                            <input type="radio" name="q<?php echo $question['id']; ?>" value="d">
                            <?php echo htmlspecialchars($question['option_d']); ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="cta-button">Submit Quiz</button>
        </form>
    </main>
</body>
</html>