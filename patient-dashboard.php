<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard | Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Top Navigation Bar */
        .top-nav {
            background-color: #007bff;
            padding: 15px 0;
            text-align: center;
        }

        .top-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .top-nav ul li {
            display: inline;
            margin: 0 15px;
        }

        .top-nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .top-nav ul li a:hover {
            text-decoration: underline;
        }

        /* Dashboard Container */
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .card {
            background: #007bff;
            color: white;
            padding: 20px;
            width: 250px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            margin: 10px;
        }

        .card:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        .card a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

    </style>
</head>
<body>

    <!-- Top Navigation Menu -->
    <nav class="top-nav">
        <ul>
            <li><a href="patient-dashboard.php">Home</a></li>
            <li><a href="appointments.php">Appointments</a></li>
            <li><a href="medical-records.php">Medical Records</a></li>
            <li><a href="billing.php">Billing</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['full_name']; ?>!</h2>
        <p>Select an option below to continue.</p>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
        <div class="card">
            <a href="book-appointment.php">📆 Book Appointment</a>
        </div>
            <div class="card">
                <a href="appointments.php">📅 View Appointments</a>
            </div>
            <div class="card">
                <a href="medical-records.php">📁 Medical Records</a>
            </div>
            <div class="card">
                <a href="billing.php">💳 Billing</a>
            </div>
            <div class="card">
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
    </div>

</body>
</html>
