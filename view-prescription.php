<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$appointment_id = $_GET['id'];
$query = "SELECT prescription FROM prescriptions WHERE appointment_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$prescription = $result->fetch_assoc();

if (!$prescription) {
    echo "No prescription found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .prescription-container {
            width: 100%;
            max-width: 800px;
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .prescription-header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .prescription-header h2 {
            font-size: 32px;
            margin: 0;
        }

        .prescription-header p {
            font-size: 18px;
            color: #666;
        }

        .doctor-info, .prescription-info {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .doctor-info strong, .prescription-info strong {
            font-weight: bold;
        }

        .prescription-info {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .prescription-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #888;
        }

    </style>
</head>
<body>

    <div class="prescription-container">
        <div class="prescription-header">
            <h2>Prescription</h2>
            <p>Issued by: Dr. [Doctor's Name]</p>
        </div>

        <div class="doctor-info">
            <p><strong>Doctor's Name:</strong> Dr. John Doe</p>
            <p><strong>Specialty:</strong> Cardiologist</p>
            <p><strong>Appointment Date:</strong> [Date of Appointment]</p>
        </div>

        <div class="prescription-info">
            <strong>Prescription Details:</strong>
            <p><?= nl2br(htmlspecialchars($prescription['prescription'])); ?></p>
        </div>

        <div class="footer">
            <p>Care Compass Hospital</p>
            <p>For inquiries, please contact us at [Contact Information]</p>
        </div>
    </div>

</body>
</html>
