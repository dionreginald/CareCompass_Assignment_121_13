<?php
// Include the database connection file
include('db.php');

// Check if the form data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data from the POST request
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // SQL query to insert data into the database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Return success response
        echo "Message sent successfully!";
    } else {
        // Return error message
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
