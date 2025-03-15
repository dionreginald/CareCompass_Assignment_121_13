<?php
session_start();
include 'db.php'; // Include the database connection file

// Check if the patient ID is provided in the URL
if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    // Fetch the patient data from the database
    $stmt = $conn->prepare("SELECT id, full_name, email, phone, password FROM patients WHERE id = ?");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If patient exists, fetch the data
        $patient = $result->fetch_assoc();
    } else {
        echo "Patient not found.";
        exit();
    }
    $stmt->close();
} else {
    echo "No patient ID specified.";
    exit();
}

// If the form is submitted, update the patient data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Hash the password before saving
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $patient['password']; // Use the existing password if not changing
    }

    // Update the patient's details in the database
    $stmt = $conn->prepare("UPDATE patients SET full_name = ?, email = ?, phone = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $full_name, $email, $phone, $hashed_password, $patient_id);
    $stmt->execute();
    
    // After updating, redirect to manage-patients.php (or show a success message)
    header('Location: manage-patients.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <style>
        /* General page styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 16px;
            color: #2c3e50;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
        }

        input:focus {
            border-color: #3498db;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #3498db;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Patient Information</h1>
        </header>

        <!-- Patient Edit Form -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($patient['full_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">New Password (Leave empty to keep existing):</label>
                <input type="password" name="password" id="password" placeholder="Enter new password">
            </div>

            <div class="form-group">
                <button type="submit">Update Patient</button>
            </div>
        </form>

        <div class="back-link">
            <a href="manage-patients.php">Back to Manage Patients</a>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
