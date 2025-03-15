<?php
session_start();
include 'db.php'; // Ensure the database connection file is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, full_name, email, password FROM patients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password (if stored as a hash)
        if (password_verify($password, $row['password'])) {
            // Store session variables
            $_SESSION['patient_id'] = $row['id'];
            $_SESSION['patient_name'] = $row['full_name'];
            $_SESSION['patient_email'] = $row['email'];

            // Redirect to dashboard
            header("Location: patient_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='patient-portal.php';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email!'); window.location.href='patient-portal.php';</script>";
    }
    
    $stmt->close();
}
$conn->close();
?>
