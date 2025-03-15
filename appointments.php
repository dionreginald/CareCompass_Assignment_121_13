<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php'; 

$patient_id = $_SESSION['patient_id'];
$query = "SELECT a.id, d.full_name AS doctor_name, d.specialty, a.appointment_date AS date, a.appointment_time AS time, a.status 
          FROM appointments a 
          JOIN doctors d ON a.doctor_id = d.id 
          WHERE a.patient_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
?>
<style>
    /* General Styling */
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: white
    }

    /* Top Navigation Bar */
    .top-nav {
        position: absolute;
        top: 0;
        width: 100%;
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

    /* Appointment Container */
    .appointment-container {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 100%;
        max-width: 900px;
        box-sizing: border-box;
        margin-top: 80px;
        border-top: 4px solid #007bff;
    }

    .appointment-container h2 {
        color: #333;
        margin-bottom: 20px;
        font-size: 32px;
        font-weight: 600;
    }

    /* Table Styling */
    .appointment-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .appointment-table th, .appointment-table td {
        padding: 12px;
        text-align: center;
        font-size: 16px;
        color: #555;
    }

    .appointment-table th {
        background-color: #007bff;
        color: white;
    }

    .appointment-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .appointment-table tr:hover {
        background-color: #d0eaff;
        cursor: pointer;
    }

    /* Appointment Status */
    .status-pending {
        color: orange;
        font-weight: bold;
    }

    .status-confirmed {
        color: green;
        font-weight: bold;
    }

    .status-cancelled {
        color: red;
        font-weight: bold;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments | Care Compass</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/appointments.css">
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

    <!-- Appointment List Container -->
    <div class="appointment-container">
        <h2>My Appointments</h2>

        <?php if (count($appointments) > 0) { ?>
            <table class="appointment-table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment) { ?>
                        <tr>
                            <td><?= htmlspecialchars($appointment['doctor_name']); ?></td>
                            <td><?= htmlspecialchars($appointment['specialty']); ?></td>
                            <td><?= htmlspecialchars($appointment['date']); ?></td>
                            <td><?= htmlspecialchars($appointment['time']); ?></td>
                            <td class="status-<?= strtolower($appointment['status']); ?>"><?= htmlspecialchars($appointment['status']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No appointments found.</p>
        <?php } ?>
    </div>

</body>
</html>
