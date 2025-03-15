<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all patients
$query = "SELECT id, full_name FROM patients";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records | Care Compass</title>
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

        .btn-success {
            background-color: #5bc0de; /* Green color for positive actions */
            border: none;
        }

        .btn-success:hover {
            background-color: #31b0d5; /* Darker green on hover */
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
        <h2 class="text-center">Your Medical Records</h2>

        <!-- Patient Table -->
        <div class="container">
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['full_name']); ?></td>
                            <td>
                                <a href="view-prescription1.php?patient_id=<?= $row['id']; ?>" class="btn btn-primary">View Prescriptions</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
