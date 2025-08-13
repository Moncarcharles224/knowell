<?php
session_start();
require_once "includes/db.php";
$message = "";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $message = "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $message = "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNOWWELL - Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-container">
        <form class="auth-form" action="signup.php" method="post">
            <h2>KNOWWELL - Sign Up</h2>
            <?php if (!empty($message)): ?>
                <div class="message-box"><?php echo $message; ?></div>
            <?php endif; ?>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Sign Up</button>
            <div class="auth-links">
                <a href="login.php">Already have an account? Login</a>
            </div>
        </form>
    </div>
</body>
</html>