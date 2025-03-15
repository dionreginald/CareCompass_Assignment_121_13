<?php
session_start();
include 'db.php'; // Database connection

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch admin details from session
$admin_id = $_SESSION['admin_id'];

// Query to fetch the admin's name from the database
$stmt = $conn->prepare("SELECT name FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($admin_name);
$stmt->fetch();
$stmt->close();

// Fetch patient details from the database
$query = "SELECT id, full_name, email, phone FROM patients"; // Removed 'age' and 'gender'
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients - Care Compass Hospitals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f2f2f2;
        }

        .sidebar {
            background-color: #333;
            width: 250px;
            position: fixed;
            height: 100%;
            padding-top: 20px;
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
        }

        header h2 {
            color: #333;
        }

        .patients-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .patients-table th, .patients-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .patients-table th {
            background-color: #4CAF50;
            color: white;
        }

        .patients-table td a {
            text-decoration: none;
            color: #007BFF;
        }

        .patients-table td a:hover {
            color: #0056b3;
        }

        .btn {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

    <!-- Admin Sidebar -->
    <aside class="sidebar">
        <nav>
            <ul>
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="manage-patients.php">Manage Patients</a></li>
                <li><a href="manage-doctors.php">Manage Doctors</a></li>
                <li><a href="add_prescription.php">Manage Prescription</a></li>
                <li><a href="admin_appointments.php">Appointments</a></li>
                <li><a href="billing.php">Billing</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="main-content">
        <header>
            <h2>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>
            <h3>Manage Patients</h3>
        </header>

        <!-- Patient Table -->
        <table class="patients-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>
                                <a href='edit-patient.php?id=" . $row['id'] . "'>Edit</a> | 
                                <a href='delete-patient.php?id=" . $row['id'] . "' class='btn' onclick='return confirm(\"Are you sure you want to delete this patient?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No patients found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php $conn->close(); ?>
