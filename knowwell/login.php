<?php
session_start();
require_once "includes/db.php";
$message = "";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["username"];
            header("Location: index.php");
            exit();
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "No account found with that email.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNOWWELL - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-container">
        <form class="auth-form" action="login.php" method="post">
            <h2>KNOWWELL - Login</h2>
            <?php if (!empty($message)): ?>
                <div class="message-box error"><?php echo $message; ?></div>
            <?php endif; ?>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
            <div class="auth-links">
                <a href="signup.php">Don't have an account? Sign up</a>
            </div>
        </form>
    </div>
</body>
</html>