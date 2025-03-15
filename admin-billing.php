<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

include 'db.php';

// Handle generating the bill
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_bill'])) {
    $patient_id = $_POST['patient_id'];
    $bill_type = $_POST['bill_type'];
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];
    $payment_status = 'Pending';  // Default status

    // Insert the bill into the billing table
    $sql = "INSERT INTO billing (patient_id, bill_type, amount, due_date, payment_status)
            VALUES ('$patient_id', '$bill_type', '$amount', '$due_date', '$payment_status')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Bill generated successfully!'); window.location.href='admin-billing.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle payment status update
if (isset($_GET['update_status'])) {
    $billing_id = $_GET['update_status'];
    $status = $_GET['status'];

    $sql = "UPDATE billing SET payment_status='$status' WHERE id=$billing_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Payment status updated successfully!'); window.location.href='admin-billing.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch patients who have made an appointment
$patients = $conn->query("SELECT DISTINCT p.id, p.full_name 
                          FROM patients p
                          JOIN appointments a ON p.id = a.patient_id
                          WHERE a.status != 'Cancelled'");

// Fetch billing data
$billings = $conn->query("SELECT b.id, p.full_name, b.bill_type, b.amount, b.due_date, b.payment_status
                          FROM billing b
                          JOIN patients p ON b.patient_id = p.id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Billing</title>
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
            <h2 class="text-center mb-3">Generate Bill</h2>

            <!-- Generate Bill Form -->
            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <select name="patient_id" class="form-control" required>
                            <option value="">Select Patient</option>
                            <?php while ($patient = $patients->fetch_assoc()): ?>
                                <option value="<?= $patient['id'] ?>"><?= $patient['full_name'] ?> (ID: <?= $patient['id'] ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="bill_type" class="form-control" required>
                            <option value="">Select Bill Type</option>
                            <option value="Booking Bill">Booking Bill</option>
                            <option value="Medicine Bill">Medicine Bill</option>
                            <option value="Other Bill">Other Bill</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="amount" placeholder="Amount" required>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" name="due_date" required>
                    </div>
                </div>
                <button type="submit" name="generate_bill" class="btn btn-success mt-3">Generate Bill</button>
            </form>
        </div>

        <!-- Billing List -->
        <div class="card mt-4">
            <h2 class="text-center mb-3">Billing List</h2>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Bill Type</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $billings->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['full_name'] ?></td>
                        <td><?= $row['bill_type'] ?></td>
                        <td><?= $row['amount'] ?></td>
                        <td><?= $row['due_date'] ?></td>
                        <td><?= $row['payment_status'] ?></td>
                        <td>
                            <!-- Mark as Paid and Cancel buttons -->
                            <a href="admin-billing.php?update_status=<?= $row['id'] ?>&status=Paid" class="btn btn-success btn-sm">Mark as Paid</a>
                            <a href="admin-billing.php?update_status=<?= $row['id'] ?>&status=Cancelled" class="btn btn-danger btn-sm">Cancel</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
