<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

include 'db.php';

// Check if patient_id is set
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Fetch prescriptions for the specific patient
    $query = "SELECT * FROM prescriptions WHERE patient_id = '$patient_id'";
    $result = $conn->query($query);
} else {
    header("Location: medical-records.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prescription | Care Compass</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Topbar Navigation Style */
        .topbar {
            background-color: #c9302c; /* Red background */
            color: white;
            padding: 10px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .topbar .navbar-nav a {
            color: white;
            font-size: 16px;
            margin-right: 20px;
            text-decoration: none;
        }

        .topbar .navbar-nav a:hover {
            color: #f8f9fa; /* Light color on hover */
            text-decoration: underline;
        }

        /* Main Content */
        .main-content {
            padding: 20px;
        }

        h2 {
            font-family: 'Arial', sans-serif;
            font-size: 32px;
            margin-top: 30px;
            color: #1b743d; /* Dark Green for headers */
        }

        .table th, .table td {
            text-align: center;
        }

        .btn-primary {
            background-color: #c9302c; /* Red color for primary buttons */
            border: none;
        }

        .btn-primary:hover {
            background-color: #bd362f; /* Darker red on hover */
        }

        .table {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <!-- Topbar Navigation -->
    <nav class="navbar navbar-expand-lg topbar">
        <a class="navbar-brand" href="patient-dashboard.php">Care Compass</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="patient-dashboard.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="medical-records.php" class="nav-link">Medical Records</a></li>
                <li class="nav-item"><a href="appointments.php" class="nav-link">Appointments</a></li>
                <li class="nav-item"><a href="billing.php" class="nav-link">Billing</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="text-center">View Prescription</h2>

        <?php if ($result->num_rows > 0) { ?>
            <table class="table table-striped text-center mt-3">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Dosage</th>
                        <th>Instructions</th>
                        <th>Date Prescribed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['medicine']); ?></td>
                            <td><?= htmlspecialchars($row['dosage']); ?></td>
                            <td><?= htmlspecialchars($row['instructions']); ?></td>
                            <td><?= htmlspecialchars($row['date_prescribed']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="text-center">No prescriptions found for this patient.</p>
        <?php } ?>
    </div>

</body>
</html>
