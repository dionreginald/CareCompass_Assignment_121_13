<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the patient_id is in the session
    if (!isset($_SESSION['patient_id'])) {
        header("Location: login.php");
        exit();
    }

    // Get the patient ID and other input values
    $patient_id = $_SESSION['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['date']; // Updated to match the column name
    $appointment_time = $_POST['time']; // Updated to match the column name

    // Prepare the SQL statement to insert the new appointment
    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("iiss", $patient_id, $doctor_id, $appointment_date, $appointment_time);

    // Execute the statement and handle success/failure
    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully!'); window.location.href='appointments.php';</script>";
    } else {
        echo "<script>alert('Error booking appointment!'); window.history.back();</script>";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
