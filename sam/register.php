<?php
require_once 'db.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $full_name = trim($_POST['full_name']);
    $password = $_POST['password'];
    
    if (empty($student_id) || empty($full_name) || empty($password)) {
        $message = 'All fields are required!';
        $messageType = 'error';
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO students (student_id, full_name, password_hash) VALUES (:student_id, :full_name, :password_hash)");
            $stmt->execute([
                ':student_id' => $student_id,
                ':full_name' => $full_name,
                ':password_hash' => $password_hash
            ]);
            
            $message = 'Registration successful! Redirecting to login...';
            $messageType = 'success';
            header("refresh:2;url=login.php");
            
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = 'Student ID already exists!';
            } else {
                $message = 'Registration failed: ' . $e->getMessage();
            }
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
    <title>Register - Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Create Account</h1>
            
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
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            
            <div class="auth-footer">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>
    </div>
</body>
</html>
