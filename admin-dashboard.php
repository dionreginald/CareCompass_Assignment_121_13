<?php
session_start();
include 'db.php'; // Database connection

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php"); // Redirect to login if not logged in
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Care Compass Hospitals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f2f2f2;
            display: flex;
        }

        .sidebar {
            background-color: #333;
            width: 250px;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            padding: 15px 20px;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 18px;
        }

        .sidebar nav ul li a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            text-align: center;
            flex-grow: 1;
        }

        h2 {
            color: #333;
        }

        .admin-image {
            margin-top: 20px;
            width: 750px;
            height: 550px;
            border-radius: 10%;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <nav>
            <ul>
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="manage-patients.php">Manage Patients</a></li>
                <li><a href="manage-doctors.php">Manage Doctors</a></li>
                <li><a href="add_prescription.php">Manage Prescription</a></li>
                <li><a href="admin_appointments.php">Appointments</a></li>
                <li><a href="admin-billing.php">Billing</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <div class="main-content">
        <h2>Welcome to the Dashboard Admin User</h2>
        <img src="assets/images/admin-profile.jpg" alt="Admin Profile Picture" class="admin-image">
    </div>
</body>
</html>

<?php $conn->close(); ?>
