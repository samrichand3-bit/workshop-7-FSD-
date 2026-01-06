<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $password = $_POST['password'];
    
    if (empty($student_id) || empty($password)) {
        $message = 'All fields are required!';
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = :student_id");
            $stmt->execute([':student_id' => $student_id]);
            $student = $stmt->fetch();
            
            if ($student) {
                if (password_verify($password, $student['password_hash'])) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['student_id'] = $student['student_id'];
                    $_SESSION['full_name'] = $student['full_name'];
                    $_SESSION['user_id'] = $student['id'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $message = 'Invalid password!';
                    $messageType = 'error';
                }
            } else {
                $message = 'Student ID not found!';
                $messageType = 'error';
            }
        } catch (PDOException $e) {
            $message = 'Login failed: ' . $e->getMessage();
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Student Login</h1>
            
            <?php if ($message): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <input type="text" id="student_id" name="student_id" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            
            <div class="auth-footer">
                Don't have an account? <a href="register.php">Register</a>
            </div>
        </div>
    </div>
</body>
</html>
