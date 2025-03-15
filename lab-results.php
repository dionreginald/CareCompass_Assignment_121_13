<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "No appointment ID specified.";
    exit();
}

$appointment_id = $_GET['id']; // Get the appointment ID from the query string
include 'db.php';

// Query to fetch lab results associated with this appointment
$query_lab_results = "SELECT test_name, result, test_date FROM lab_results WHERE appointment_id = ?";
$stmt_lab_results = $conn->prepare($query_lab_results);
$stmt_lab_results->bind_param("i", $appointment_id);
$stmt_lab_results->execute();
$result_lab_results = $stmt_lab_results->get_result();

$lab_results = [];
if ($result_lab_results->num_rows > 0) {
    while ($row = $result_lab_results->fetch_assoc()) {
        $lab_results[] = $row;
    }
}

// Query to fetch prescriptions for the given appointment
$query_prescriptions = "SELECT prescription_details, date_added FROM prescriptions WHERE appointment_id = ?";
$stmt_prescriptions = $conn->prepare($query_prescriptions);
$stmt_prescriptions->bind_param("i", $appointment_id);
$stmt_prescriptions->execute();
$result_prescriptions = $stmt_prescriptions->get_result();

$prescriptions = [];
if ($result_prescriptions->num_rows > 0) {
    while ($row = $result_prescriptions->fetch_assoc()) {
        $prescriptions[] = $row;
    }
}

// Close database connections
$stmt_lab_results->close();
$stmt_prescriptions->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Results & Prescription | Care Compass</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
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

        .container {
            width: 100%;
            max-width: 800px;
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2>Lab Results & Prescription</h2>
            <p>Details for your recent appointment</p>
        </div>

        <!-- Lab Results Section -->
        <div class="lab-results">
            <h3>Lab Results</h3>
            <?php if (!empty($lab_results)): ?>
                <table class="table">
                    <tr>
                        <th>Test Name</th>
                        <th>Result</th>
                        <th>Date</th>
                    </tr>
                    <?php foreach ($lab_results as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['test_name']); ?></td>
                            <td><?= htmlspecialchars($row['result']); ?></td>
                            <td><?= htmlspecialchars($row['test_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No lab results found for this appointment.</p>
            <?php endif; ?>
        </div>

        <!-- Prescription Section -->
        <div class="prescription">
            <h3>Prescription</h3>
            <?php if (!empty($prescriptions)): ?>
                <table class="table">
                    <tr>
                        <th>Prescription Details</th>
                        <th>Date Added</th>
                    </tr>
                    <?php foreach ($prescriptions as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['prescription_details']); ?></td>
                            <td><?= htmlspecialchars($row['date_added']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No prescription found for this appointment.</p>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>Care Compass Hospital | For any inquiries, contact us at [Contact Information]</p>
        </div>
    </div>

</body>
</html>
