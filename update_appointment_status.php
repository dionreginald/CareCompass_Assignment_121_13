<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['appointment_id'], $_POST['status'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $status = $_POST['status'];

    // Validate status value
    $allowed_statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];
    if (!in_array($status, $allowed_statuses)) {
        die("Invalid status.");
    }

    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $appointment_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Appointment status updated successfully.";
    } else {
        $_SESSION['message'] = "Failed to update appointment status.";
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_appointments.php");
    exit();
} else {
    die("Invalid request.");
}
?>
