<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'care_compass');  // Update with your DB credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Securely hash the password
$password = password_hash('adminpassword', PASSWORD_DEFAULT);  // This will encrypt the password

// SQL query to insert admin into the database
$sql = "INSERT INTO admins (email, password) VALUES ('admin@example.com', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
