<?php
session_start();
include 'db.php'; // Include database connection

// Initialize variables
$email = $password = $error = "";

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve POST data
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate input
    if (empty($email) || empty($password)) {
        $error = "Please fill in both fields.";
    } else {
        // Query to check if the admin exists
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email); // 's' for string
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Fetch the admin data
            $stmt->bind_result($admin_id, $stored_password);
            $stmt->fetch();
            
            // Verify password
            if (password_verify($password, $stored_password)) {
                // Password is correct, set session variables
                $_SESSION['admin_id'] = $admin_id;
                header("Location: admin-dashboard.php"); // Redirect to dashboard
                exit();
            } else {
                $error = "Incorrect email or password.";
            }
        } else {
            $error = "Admin not found.";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Full-screen background video */
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        video.bg-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            opacity: 0.7; /* Slight transparency for overlay effect */
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .login-container:hover {
            transform: scale(1.02);
        }

        .login-box {
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .welcome-text {
            color: blue;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            animation: fadeIn 2s ease-in-out;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 5px;
            display: block;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error {
            color: #e74c3c;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .forgot-password {
            margin-top: 10px;
            font-size: 14px;
            color: #3498db;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>

<!-- Background Video -->
<video class="bg-video" autoplay loop muted>
    <source src="https://videos.pexels.com/video-files/7234993/7234993-uhd_2560_1440_30fps.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<!-- Admin Login Form -->
<div class="login-container">
    <div class="login-box">
        <div class="welcome-text">Welcome Admin User to the Admin Dashboard, Let's login now!</div>
        <h2>Admin Login</h2>
        
        <!-- Display error if any -->
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="admin_login.php" method="POST">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required value="<?php echo htmlspecialchars($email); ?>">
            </div>
            
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required value="<?php echo htmlspecialchars($password); ?>">
            </div>
            
            <button type="submit">Login</button>
        </form>

        <!-- Forgot password link -->
        <a href="#" class="forgot-password">Forgot your password?</a>
    </div>
</div>

</body>
</html>
