<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["user_id"];
$username = htmlspecialchars($_SESSION["user_name"]);

// Fetch all courses
$courses = [];
$result = $conn->query("SELECT * FROM courses");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Fetch user's completed courses
$completedCourses = [];
$stmt = $conn->prepare("SELECT course_id, score FROM user_progress WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$progressResult = $stmt->get_result();
while ($row = $progressResult->fetch_assoc()) {
    $completedCourses[$row['course_id']] = $row['score'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNOWWELL - Courses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="logo">KNOWWELL</span>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <span>Welcome, <?php echo $username; ?></span>
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <main class="container">
        <h2>Select a Course</h2>
        <div class="course-list">
            <?php if (empty($courses)): ?>
                <p>No courses available yet.</p>
            <?php else: ?>
                <?php foreach ($courses as $course): ?>
                    <div class="course-item">
                        <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                        <?php if (array_key_exists($course['id'], $completedCourses)): ?>
                            <div class="course-status completed">
                                Completed! Your score was: <?php echo $completedCourses[$course['id']]; ?>/5
                                <a href="quiz.php?course_id=<?php echo $course['id']; ?>" class="cta-button-small">Try Again</a>
                            </div>
                        <?php else: ?>
                            <div class="course-status">
                                <a href="quiz.php?course_id=<?php echo $course['id']; ?>" class="cta-button">Start Quiz</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>