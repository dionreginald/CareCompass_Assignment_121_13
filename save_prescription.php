<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $patient_id = $_POST['patient_id'];
    $medicine = $_POST['medicine'];
    $dosage = $_POST['dosage'];
    $instructions = $_POST['instructions'];

    // Current date when the prescription is made
    $date_prescribed = date('Y-m-d H:i:s');

    // Insert into the prescriptions table
    $query = "INSERT INTO prescriptions (patient_id, medicine, dosage, instructions, date_prescribed)
              VALUES ('$patient_id', '$medicine', '$dosage', '$instructions', '$date_prescribed')";

    if ($conn->query($query) === TRUE) {
        // Redirect with success message
        header("Location: add_prescription.php?success=true");
        exit();
    } else {
        // Handle any errors
        echo "Error: " . $conn->error;
    }
}
?>
