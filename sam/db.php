<?php 

$server = 'localhost';
$username = 'np03cs4a240323';
$password = 'NfN6EL2GQD';
$database = 'np03cs4a240323';

try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    // Reconnect using the database
    $pdo = new PDO(
        "mysql:host=$server;dbname=$database;charset=utf8mb4",
        $username,
        $password,
        $options
    );

    // Create students table if it doesn't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS `students` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `student_id` VARCHAR(20) UNIQUE NOT NULL,
        `full_name` VARCHAR(100) NOT NULL,
        `password_hash` VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}

?>
