<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) { // Assuming user 1 is an admin
    header("Location: login.php");
    exit();
}

$message = "";
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$edit_course = null;
$edit_question = null;

if ($action == 'edit_course' && $id) {
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_course = $result->fetch_assoc();
    $stmt->close();
}

if ($action == 'edit_question' && $id) {
    $stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_question = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($action == 'add_course') {
        $course_name = trim($_POST['course_name']);
        if (!empty($course_name)) {
            $stmt = $conn->prepare("INSERT INTO courses (course_name) VALUES (?)");
            $stmt->bind_param("s", $course_name);
            if ($stmt->execute()) {
                $message = "New course added successfully!";
            } else {
                $message = "Error: " . $conn->error;
            }
            $stmt->close();
        }
    } elseif ($action == 'update_course') {
        $course_name = trim($_POST['course_name']);
        if (!empty($course_name) && $id) {
            $stmt = $conn->prepare("UPDATE courses SET course_name = ? WHERE id = ?");
            $stmt->bind_param("si", $course_name, $id);
            if ($stmt->execute()) {
                $message = "Course updated successfully!";
            } else {
                $message = "Error: " . $conn->error;
            }
            $stmt->close();
        }
    } elseif ($action == 'delete_course') {
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Course deleted successfully!";
            } else {
                $message = "Error: " . $conn->error;
            }
            $stmt->close();
        }
    } elseif ($action == 'add_question') {
        $course_id = $_POST['course_id'];
        $question_text = trim($_POST['question_text']);
        $option_a = trim($_POST['option_a']);
        $option_b = trim($_POST['option_b']);
        $option_c = trim($_POST['option_c']);
        $option_d = trim($_POST['option_d']);
        $correct_option = trim($_POST['correct_option']);

        if (!empty($question_text) && !empty($correct_option)) {
            $stmt = $conn->prepare("INSERT INTO questions (course_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $course_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option);
            if ($stmt->execute()) {
                $message = "New question added successfully!";
            } else {
                $message = "Error: " . $conn->error;
            }
            $stmt->close();
        }
    } elseif ($action == 'update_question') {
        $course_id = $_POST['course_id'];
        $question_text = trim($_POST['question_text']);
        $option_a = trim($_POST['option_a']);
        $option_b = trim($_POST['option_b']);
        $option_c = trim($_POST['option_c']);
        $option_d = trim($_POST['option_d']);
        $correct_option = trim($_POST['correct_option']);

        if (!empty($question_text) && !empty($correct_option) && $id) {
            $stmt = $conn->prepare("UPDATE questions SET course_id = ?, question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_option = ? WHERE id = ?");
            $stmt->bind_param("issssssi", $course_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $id);
            if ($stmt->execute()) {
                $message = "Question updated successfully!";
            } else {
                $message = "Error: " . $conn->error;
            }
            $stmt->close();
        }
    } elseif ($action == 'delete_question') {
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Question deleted successfully!";
            } else {
                $message = "Error: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

$courses = [];
$result = $conn->query("SELECT * FROM courses");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

$questions = [];
$result = $conn->query("SELECT q.id, q.question_text, c.course_name FROM questions q JOIN courses c ON q.course_id = c.id");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNOWWELL - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="logo">KNOWWELL</span>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="courses.php">Courses</a>
                <span>Welcome, Admin</span>
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>
    <main class="container">
        <h2>Admin Panel</h2>
        <?php if (!empty($message)): ?>
            <div class="message-box"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="crud-section">
            <h3><?php echo $edit_course ? "Edit Course" : "Add New Course"; ?></h3>
            <form action="admin.php" method="post">
                <input type="hidden" name="action" value="<?php echo $edit_course ? "update_course" : "add_course"; ?>">
                <?php if ($edit_course): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_course['id']); ?>">
                <?php endif; ?>
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($edit_course['course_name'] ?? ''); ?>" required>
                <button type="submit" class="cta-button"><?php echo $edit_course ? "Update Course" : "Add Course"; ?></button>
            </form>
        </div>
        
        <div class="crud-section">
            <h3>Existing Courses</h3>
            <ul>
                <?php foreach ($courses as $course): ?>
                    <li>
                        <?php echo htmlspecialchars($course['course_name']); ?>
                        <div class="crud-buttons">
                            <a href="admin.php?action=edit_course&id=<?php echo $course['id']; ?>" class="edit-button">Edit</a>
                            <form action="admin.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="delete_course">
                                <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                                <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this course and all its questions?');">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <hr/>

        <div class="crud-section">
            <h3><?php echo $edit_question ? "Edit Question" : "Add New Question"; ?></h3>
            <form action="admin.php" method="post">
                <input type="hidden" name="action" value="<?php echo $edit_question ? "update_question" : "add_question"; ?>">
                <?php if ($edit_question): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_question['id']); ?>">
                <?php endif; ?>
                <label for="course_select">Select Course:</label>
                <select id="course_select" name="course_id" required>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course['id']; ?>" <?php echo ($edit_question && $edit_question['course_id'] == $course['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($course['course_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="question_text">Question:</label>
                <textarea id="question_text" name="question_text" required><?php echo htmlspecialchars($edit_question['question_text'] ?? ''); ?></textarea>
                <label for="option_a">Option A:</label>
                <input type="text" id="option_a" name="option_a" value="<?php echo htmlspecialchars($edit_question['option_a'] ?? ''); ?>" required>
                <label for="option_b">Option B:</label>
                <input type="text" id="option_b" name="option_b" value="<?php echo htmlspecialchars($edit_question['option_b'] ?? ''); ?>" required>
                <label for="option_c">Option C:</label>
                <input type="text" id="option_c" name="option_c" value="<?php echo htmlspecialchars($edit_question['option_c'] ?? ''); ?>" required>
                <label for="option_d">Option D:</label>
                <input type="text" id="option_d" name="option_d" value="<?php echo htmlspecialchars($edit_question['option_d'] ?? ''); ?>" required>
                <label for="correct_option">Correct Option (a, b, c, or d):</label>
                <input type="text" id="correct_option" name="correct_option" value="<?php echo htmlspecialchars($edit_question['correct_option'] ?? ''); ?>" required pattern="[a-d]">
                <button type="submit" class="cta-button"><?php echo $edit_question ? "Update Question" : "Add Question"; ?></button>
            </form>
        </div>

        <div class="crud-section">
            <h3>Existing Questions </h3>
            <ul>
                <?php foreach ($questions as $question): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($question['course_name']); ?>:</strong> <?php echo htmlspecialchars($question['question_text']); ?>
                        <div class="crud-buttons">
                            <a href="admin.php?action=edit_question&id=<?php echo $question['id']; ?>" class="edit-button">Edit</a>
                            <form action="admin.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="delete_question">
                                <input type="hidden" name="id" value="<?php echo $question['id']; ?>">
                                <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this question?');">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
</body>
</html>