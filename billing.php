<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
include 'db.php';

// Query to fetch billing details for the logged-in patient
$query = "SELECT b.id, 
                 b.appointment_id, 
                 b.due_date, 
                 b.bill_type, 
                 b.amount, 
                 b.payment_status
          FROM billing b
          WHERE b.patient_id = ? 
          ORDER BY b.due_date DESC";

$stmt = $conn->prepare($query);

// Check if the statement preparation was successful
if ($stmt === false) {
    die('Error preparing the statement: ' . $conn->error);
}

$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$invoices = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : null;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing | Care Compass</title>
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

        .billing-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .billing-table th, .billing-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .billing-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .payment-status {
            font-weight: bold;
        }

        .payment-status.Pending {
            color: #ff9800;
        }

        .payment-status.Paid {
            color: #4caf50;
        }

        .payment-status.Cancelled {
            color: #f44336;
        }

        .print-button {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        .billing-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }

        /* Popup message styles */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 2px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .popup button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #45a049;
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
            <h2>Billing Information</h2>
            <p>View your invoices for recent appointments</p>
        </div>

        <?php if ($invoices): ?>
            <table class="billing-table">
                <thead>
                    <tr>
                        <th>Due Date</th>
                        <th>Bill Type</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?= htmlspecialchars(date('F j, Y', strtotime($invoice['due_date']))); ?></td>
                            <td><?= htmlspecialchars($invoice['bill_type']); ?></td>
                            <td>$<?= number_format($invoice['amount'], 2); ?></td>
                            <td class="payment-status <?= htmlspecialchars($invoice['payment_status']); ?>">
                                <?= htmlspecialchars($invoice['payment_status']); ?>
                            </td>
                            <td>
                                <button class="print-button" onclick="showPopup()">Print Bill</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No billing information found for your account.</p>
        <?php endif; ?>

        <div class="billing-footer">
            <p>Care Compass Hospital | For inquiries, contact us at [Contact Information]</p>
        </div>
    </div>

    <!-- Popup message -->
    <div class="popup-overlay" id="popupOverlay"></div>
    <div class="popup" id="popupMessage">
        <p>Bill is sent to your email and your mobile number</p>
        <button onclick="closePopup()">OK</button>
    </div>

    <script>
        // Show the popup
        function showPopup() {
            document.getElementById('popupOverlay').style.display = 'block';
            document.getElementById('popupMessage').style.display = 'block';
        }

        // Close the popup
        function closePopup() {
            document.getElementById('popupOverlay').style.display = 'none';
            document.getElementById('popupMessage').style.display = 'none';
        }
    </script>

</body>
</html>
