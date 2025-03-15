<?php
// Enable error reporting for debugging (Remove in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = getenv('DB_SERVER') ?: "localhost"; 
$username   = getenv('DB_USERNAME') ?: "root";     
$password   = getenv('DB_PASSWORD') ?: "";          
$dbname     = getenv('DB_NAME') ?: "care_compass";    

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Set character set to UTF-8
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    exit("Database connection failed: " . $conn->connect_error);
}

// Connection successful
?>
