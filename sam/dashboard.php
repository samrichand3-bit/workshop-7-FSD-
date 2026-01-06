<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <h1>Sam</h1>
        <div class="nav-links">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="dashboard.php?logout=1" class="btn btn-danger">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="card">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?></h2>
            <p>Student ID: <?php echo htmlspecialchars($_SESSION['student_id']); ?></p>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <h3>Grades</h3>
                <p>View academic performance</p>
            </div>
            
            <div class="info-item">
                <h3>Schedule</h3>
                <p>Class timetable</p>
            </div>
            
            <div class="info-item">
                <h3>Assignments</h3>
                <p>Pending submissions</p>
            </div>
            
            <div class="info-item">
                <h3>Announcements</h3>
                <p>Latest updates</p>
            </div>
        </div>
    </div>
</body>
</html>
