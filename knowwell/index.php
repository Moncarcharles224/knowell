<?php
session_start();
require_once "includes/db.php";

$loggedIn = isset($_SESSION["user_id"]);
$username = $loggedIn ? htmlspecialchars($_SESSION["user_name"]) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNOWWELL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="logo">KNOWWELL</span>
            <?php if ($loggedIn): ?>
                <div class="nav-links">
                    <span>Welcome, <?php echo $username; ?></span>
                    <a href="courses.php">Courses</a>
                    <a href="logout.php">Logout</a>
                </div>
            <?php else: ?>
                <div class="nav-links">
                    <a href="login.php">Login</a>
                    <a href="signup.php">Sign Up</a>
                </div>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">
        <?php if ($loggedIn): ?>
            <h2>Welcome back, <?php echo $username; ?>!</h2>
            <p>Select a course below to start a new quiz or review your progress.</p>
            <a href="courses.php" class="cta-button">View Courses</a>
            <?php else: ?>
            <h2>Welcome to KNOWWELL!</h2>
            <p>Please <a href="login.php">login</a> or <a href="signup.php">sign up</a> to start taking quizzes.</p>
        <?php endif; ?>
    <div id="fact-of-the-day" class="fact-box"></div>
    </main>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_api.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const factContainer = document.getElementById('fact-of-the-day');
            if (data && data.text) {
                factContainer.innerHTML = `<p><strong>Did you know?</strong> ${data.text}</p>`;
            } else {
                factContainer.innerHTML = `<p>Could not load a fact right now. Please try again later.</p>`;
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            const factContainer = document.getElementById('fact-of-the-day');
            factContainer.innerHTML = `<p>Error loading fact.</p>`;
        });
});
</script>
</body>
</html>