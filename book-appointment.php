<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php'; 

// Fetch available doctors from database
$doctorQuery = "SELECT id, full_name, specialty FROM doctors";
$result = $conn->query($doctorQuery);
$doctors = $result->fetch_all(MYSQLI_ASSOC);
?>
<style>
    /* General Styling */
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
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

    /* Appointment Form Container */
    .appointment-container {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 100%;
        max-width: 600px;
        box-sizing: border-box;
        margin-top: 70px; /* Prevents overlap with the navbar */
    }

    .appointment-container h2 {
        color: #333;
        margin-bottom: 20px;
    }

    /* Form Styling */
    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    label {
        font-size: 16px;
        color: #333;
        text-align: left;
        margin-bottom: 5px;
    }

    select, input {
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 100%;
        box-sizing: border-box;
    }

    select:focus, input:focus {
        outline: none;
        border-color: #007bff;
    }

    /* Button Styling */
    .btn-book {
        background-color: #007bff;
        color: white;
        padding: 15px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-book:hover {
        background-color: #0056b3;
    }

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment | Care Compass</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/appointments.css"> <!-- New CSS -->
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

    <!-- Appointment Booking Form -->
    <div class="appointment-container">
        <h2>Book an Appointment</h2>
        <form action="book-appointment-process.php" method="POST">
            <label for="doctor">Select Doctor:</label>
            <select name="doctor_id" required>
                <option value="">Choose a doctor</option>
                <?php foreach ($doctors as $doctor) { ?>
                    <option value="<?= $doctor['id']; ?>"><?= $doctor['full_name']; ?> (<?= $doctor['specialty']; ?>)</option>
                <?php } ?>
            </select>

            <label for="date">Choose Date:</label>
            <input type="date" name="date" required>

            <label for="time">Choose Time:</label>
            <input type="time" name="time" required>

            <button type="submit" class="btn-book">Book Appointment</button>
        </form>
    </div>

</body>
</html>
