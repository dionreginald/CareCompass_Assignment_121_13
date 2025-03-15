<?php
session_start();
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']); // Remove spaces from email
    $password = $_POST['password'];

    // Prepare SQL to check if the email exists
    $stmt = $conn->prepare("SELECT id, full_name, password FROM patients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $full_name, $hashed_password);
        $stmt->fetch();

        // Verify the entered password against the hashed password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['patient_id'] = $id;
            $_SESSION['full_name'] = $full_name;
            header("Location: patient-dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password!";
            header("Location: login.php"); // Redirect back to login
            exit();
        }
    } else {
        $_SESSION['error'] = "Email not found!";
        header("Location: login.php"); // Redirect back to login
        exit();
    }

    $stmt->close();
}
$conn->close();
?>

<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        /* Container to keep the content below the header */
        .content-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding-top: 60px; /* Reduced padding */
        }

        /* Login Form Styling */
        .login-form {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .login-container a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
            text-align: center;
            display: block;
            margin-top: 15px;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        /* Header Styling */
        header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background-color: #333;
            padding: 15px 0;
            color: white;
            text-align: center;
            font-size: 18px;
            z-index: 1000; /* Ensure it's above the content */
        }
    </style>
</head>
<body>
<div class="loader">
        <p>Loading...</p>
    </div>

    <div class="loader">
    <div class="spinner"></div>
</div>

    <div class="content-container">
        <div class="login-form">
            <h2>Login to Your Account</h2>

            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']); // Clear the error after displaying
            }
            ?>

            <form action="login.php" method="POST">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Login</button>
            </form>

            <a href="register.php">Register youreself</a> <br>

            <a href="forgot-password.php">Forgot Password?</a>
        </div>
    </div>

</body>
</html>
