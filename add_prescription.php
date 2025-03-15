<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

include 'db.php';

// Fetch confirmed appointments with patient and doctor information
$query = "SELECT p.id, p.full_name AS patient_name, d.full_name AS doctor_name, d.specialty 
          FROM patients p 
          JOIN appointments a ON p.id = a.patient_id 
          JOIN doctors d ON a.doctor_id = d.id 
          WHERE a.status = 'Confirmed'"; 
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescription | Care Compass</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

        .table {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background: #007bff;
            color: white;
        }

        .modal-header, .modal-footer {
            background-color: #007bff;
            color: white;
        }

        .modal-body {
            padding: 20px;
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

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="text-center mt-5">Add Prescription</h2>

        <table class="table table-striped text-center mt-3">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Specialty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['patient_name']); ?></td>
                        <td><?= htmlspecialchars($row['doctor_name']); ?></td>
                        <td><?= htmlspecialchars($row['specialty']); ?></td>
                        <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prescriptionModal" data-patient-id="<?= $row['id']; ?>">Add Prescription</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Prescription Modal -->
    <div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prescriptionModalLabel">Add Prescription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="save_prescription.php" method="POST">
                        <input type="hidden" name="patient_id" id="patient_id">
                        
                        <!-- Medicine Dropdown -->
                        <div class="mb-3">
                            <label for="medicine" class="form-label">Medicine</label>
                            <select class="form-control" name="medicine" id="medicine" required>
                                <option value="">Select Medicine</option>
                                <!-- List of medicines -->
                                <option value="Paracetamol">Paracetamol</option>
                                <option value="Amoxicillin">Amoxicillin</option>
                                <option value="Ibuprofen">Ibuprofen</option>
                                <!-- Other options... -->
                            </select>
                        </div>

                        <!-- Dosage Dropdown -->
                        <div class="mb-3">
                            <label for="dosage" class="form-label">Dosage</label>
                            <select class="form-control" name="dosage" id="dosage" required>
                                <option value="">Select Dosage</option>
                                <option value="500mg">500mg</option>
                                <option value="1g">1g</option>
                                <!-- Other options... -->
                            </select>
                        </div>

                        <!-- Instructions Dropdown -->
                        <div class="mb-3">
                            <label for="instructions" class="form-label">Instructions</label>
                            <select class="form-control" name="instructions" id="instructions" required>
                                <option value="">Select Instructions</option>
                                <option value="Take with food">Take with food</option>
                                <option value="Take on an empty stomach">Take on an empty stomach</option>
                                <!-- Other options... -->
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Save Prescription</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var prescriptionModal = document.getElementById('prescriptionModal');
        prescriptionModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var patientId = button.getAttribute('data-patient-id');
            document.getElementById('patient_id').value = patientId;
        });
    </script>
</body>
</html>
