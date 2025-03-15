<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Insert into the patients table
    $stmt = $conn->prepare("INSERT INTO patients (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $phone, $password);

    if ($stmt->execute()) {
        echo "<p>Registration successful! You can now log in.</p>";
    } else {
        echo "<p>Error registering. Please try again.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
