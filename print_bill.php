<?php
// Check if the bill ID is passed
if (!isset($_GET['bill_id'])) {
    die('No bill ID specified');
}

// Get the bill ID from the URL
$bill_id = $_GET['bill_id'];

// Include database connection
include 'db.php';

// Query to fetch billing details for the selected bill
$query = "SELECT b.id, 
                 b.appointment_id, 
                 b.due_date, 
                 b.bill_type, 
                 b.amount, 
                 b.payment_status,
                 p.full_name,
                 p.email
          FROM billing b
          JOIN patients p ON b.patient_id = p.id
          WHERE b.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the bill exists
if ($result->num_rows === 0) {
    die('Bill not found');
}

$bill = $result->fetch_assoc();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill | Care Compass Hospitals</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

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

        .billing-container {
            width: 100%;
            max-width: 900px;
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }

        .billing-header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .billing-header h2 {
            font-size: 32px;
            margin: 0;
        }

        .billing-info {
            margin-bottom: 20px;
        }

        .billing-info p {
            font-size: 16px;
        }

        .print-button {
            text-align: center;
            margin-top: 20px;
        }

        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .print-button button:hover {
            background-color: #0056b3;
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

    <div class="billing-container">
        <div class="billing-header">
            <h2>Bill Information</h2>
            <p>Details for your selected bill</p>
        </div>

        <div class="billing-info">
            <p><strong>Patient Name:</strong> <?= htmlspecialchars($bill['full_name']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($bill['email']); ?></p>
            <p><strong>Bill Type:</strong> <?= htmlspecialchars($bill['bill_type']); ?></p>
            <p><strong>Amount:</strong> $<?= number_format($bill['amount'], 2); ?></p>
            <p><strong>Due Date:</strong> <?= htmlspecialchars(date('F j, Y', strtotime($bill['due_date']))); ?></p>
            <p><strong>Payment Status:</strong> <?= htmlspecialchars($bill['payment_status']); ?></p>
        </div>

        <!-- Print Bill Button -->
        <div class="print-button">
            <button onclick="window.print();">Print Bill</button>
        </div>
    </div>

    <!-- Print functionality (JavaScript) -->
    <script>
        function printBill() {
            window.print(); // Trigger the browser's print dialog
        }
    </script>

</body>
</html>
