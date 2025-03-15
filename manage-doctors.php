<?php
session_start();
include 'db.php'; // Database connection

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php"); // Redirect to login if not logged in
    exit();
}

// Handle adding a new doctor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_doctor'])) {
    $name = $_POST['full_name'];
    $specialty = $_POST['specialty'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO doctors (full_name, specialty, email, phone) VALUES ('$name', '$specialty', '$email', '$phone')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Doctor added successfully!'); window.location.href='manage-doctors.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle deleting a doctor
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM doctors WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Doctor deleted successfully!'); window.location.href='manage-doctors.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all doctors
$doctors = $conn->query("SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f2f2f2;
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
    </style>
</head>
<body>
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
        <h2 class="text-center text-primary">Manage Doctors</h2>
        
        <!-- Add Doctor Form -->
        <div class="card shadow mt-4">
            <div class="card-header bg-primary text-white">Add New Doctor</div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="specialty" placeholder="Specialty" required>
                        </div>
                        <div class="col-md-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                        </div>
                    </div>
                    <button type="submit" name="add_doctor" class="btn btn-success mt-3">Add Doctor</button>
                </form>
            </div>
        </div>

        <!-- Doctors List -->
        <div class="card shadow mt-4">
            <div class="card-header bg-secondary text-white">Doctors List</div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Specialty</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $doctors->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['specialty'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td>
                                <a href="manage-doctors.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
