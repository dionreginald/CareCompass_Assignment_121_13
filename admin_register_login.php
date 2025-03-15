<?php
// Start session
session_start();

// Initialize variables
$email = $password = $confirm_password = "";
$error_message = $success_message = "";

// Database connection
$conn = new mysqli('localhost', 'root', '', 'care_compass');  // Update your database credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin registration logic
if (isset($_POST['register'])) {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Sanitize email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Admin with this email already exists.";
        } else {
            // Insert new admin into the database
            $insert_sql = "INSERT INTO admins (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ss", $email, $hashed_password);
            if ($stmt->execute()) {
                $success_message = "Admin registered successfully!";
            } else {
                $error_message = "Failed to register admin. Please try again.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-96">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Admin Registration</h2>

        <!-- Display error or success message -->
        <?php if ($error_message != ""): ?>
            <div class="text-red-600 mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message != ""): ?>
            <div class="text-green-600 mb-4"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- Admin Registration Form -->
        <form method="POST">
            <input type="email" name="email" placeholder="Email" class="w-full p-3 border rounded-lg mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-3 border rounded-lg mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" class="w-full p-3 border rounded-lg mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <button type="submit" name="register" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Register</button>
        </form>
    </div>

</body>
</html>
