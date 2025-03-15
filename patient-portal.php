<?php include('includes/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal | Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .patient-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 30vh;
            text-align: center;
            background:  #007bff;
            margin-bottom: 20px;
        }
        .patient-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .patient-tab-btn {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin: 0 10px;
            border-radius: 5px;
        }
        .patient-tab-btn.active {
            background: #0056b3;
        }
        .patient-form-container {
            display: none;
        }
        .patient-form-container.active {
            display: block;
        }
        .patient-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .patient-cta-btn {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Patient Portal</h1>
            <p>Login to access your medical records, appointments, and more.</p>
        </div>
    </section>

    <div class="patient-container">
        <!-- Tabs for switching between Login & Register -->
        <div class="patient-tabs">
            <button class="patient-tab-btn active" onclick="showPatientTab('login-form')">Login</button>
            <button class="patient-tab-btn" onclick="showPatientTab('register-form')">Register</button>
        </div>

        <!-- Patient Login Form -->
        <div id="login-form" class="patient-form-container active">
            <h2>Login to Your Account</h2>
            <form class="patient-form" action="patient-portal-process.php" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="Enter your email">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required placeholder="Enter your password">

                <button type="submit" class="patient-cta-btn">Login</button>
            </form>
        </div>

        <!-- Patient Registration Form -->
        <div id="register-form" class="patient-form-container">
            <h2>Register as a Patient</h2>
            <form class="patient-form" action="patient-register-process.php" method="POST">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" required placeholder="Enter your full name">

                <label for="email_reg">Email</label>
                <input type="email" name="email" id="email_reg" required placeholder="Enter your email">

                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" required placeholder="Enter your phone number">

                <label for="password_reg">Password</label>
                <input type="password" name="password" id="password_reg" required placeholder="Create a password">

                <button type="submit" class="patient-cta-btn">Register</button>
            </form>
        </div>
    </div>

    <script>
        function showPatientTab(tabId) {
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.remove('active');
            document.getElementById(tabId).classList.add('active');

            document.querySelectorAll('.patient-tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
        }
    </script>

    <?php include('includes/footer.php'); ?>

</body>
</html>
