<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

include 'db.php';

$query = "SELECT a.id, p.full_name AS patient_name, d.full_name AS doctor_name, d.specialty, 
                 a.appointment_date AS date, a.appointment_time AS time, a.status 
          FROM appointments a
          JOIN doctors d ON a.doctor_id = d.id
          JOIN patients p ON a.patient_id = p.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments | Care Compass</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            background-color: #333;
            width: 250px;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            padding: 15px 20px;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 18px;
        }

        .sidebar nav ul li a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            text-align: center;
            flex-grow: 1;
        }

        .card {
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .table {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background: #007bff;
            color: white;
        }

        .status {
            font-weight: bold;
            border-radius: 20px;
            padding: 5px 12px;
            display: inline-block;
        }

        .status-pending {
            background: orange;
            color: white;
        }

        .status-confirmed {
            background: green;
            color: white;
        }

        .status-completed {
            background: blue;
            color: white;
        }

        .status-cancelled {
            background: red;
            color: white;
        }

        .update-form select {
            border-radius: 5px;
            padding: 5px;
            margin-right: 5px;
        }

        .update-form button {
            background: #007bff;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .update-form button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <nav>
            <ul>
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="manage-patients.php">Manage Patients</a></li>
                <li><a href="manage-doctors.php">Manage Doctors</a></li>
                <li><a href="add_prescription.php">Manage Prescription</a></li>
                <li><a href="admin_appointments.php">Appointments</a></li>
                <li><a href="admin-billing.php">Billing</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <div class="main-content">
        <div class="card">
            <h2 class="text-center mb-3">Manage Appointments</h2>

            <?php if ($result->num_rows > 0) { ?>
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Specialty</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($appointment = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['patient_name']); ?></td>
                                <td><?= htmlspecialchars($appointment['doctor_name']); ?></td>
                                <td><?= htmlspecialchars($appointment['specialty']); ?></td>
                                <td><?= htmlspecialchars($appointment['date']); ?></td>
                                <td><?= htmlspecialchars($appointment['time']); ?></td>
                                <td>
                                    <span class="status status-<?= strtolower($appointment['status']); ?>">
                                        <?= htmlspecialchars($appointment['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="update_appointment_status.php" method="POST" class="update-form d-flex align-items-center">
                                        <input type="hidden" name="appointment_id" value="<?= $appointment['id']; ?>">
                                        <select name="status" class="form-select">
                                            <option value="Pending" <?= $appointment['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Confirmed" <?= $appointment['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="Completed" <?= $appointment['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="Cancelled" <?= $appointment['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary ms-2">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="text-center text-muted">No appointments found.</p>
            <?php } ?>
        </div>
    </div>

</body>
</html>
