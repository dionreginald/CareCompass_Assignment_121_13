<?php
include('db.php');  // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $patient_name = $_POST['patient_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $doctor = $_POST['doctor'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $notes = $_POST['notes'];

    // Insert the data into the appointments table
    $stmt = $conn->prepare("INSERT INTO appointments (patient_name, email, phone, service, doctor, appointment_date, appointment_time, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $patient_name, $email, $phone, $service, $doctor, $appointment_date, $appointment_time, $notes);

    if ($stmt->execute()) {
        $message = "Your appointment has been successfully booked!";
        $status = "success";
    } else {
        $message = "There was an error while booking your appointment. Please try again.";
        $status = "error";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation - Care Compass Hospitals</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f8ff;
            text-align: center;
            padding: 20px;
        }

        .confirmation-box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .message {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .message.success {
            color: #4caf50;
        }

        .message.error {
            color: #f44336;
        }

        .countdown {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .redirect-message {
            font-size: 1rem;
            color: #555;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <div class="confirmation-box">
        <h1>Appointment Confirmation</h1>
        <div class="message <?php echo $status; ?>"><?php echo $message; ?></div>
        <div class="countdown" id="countdown">Redirecting in 5 seconds...</div>
        <div class="redirect-message">If not redirected automatically, <a href="javascript:history.back()">click here</a> to go back.</div>
    </div>

    <script>
        // Countdown function
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');

        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.innerText = `Redirecting in ${countdown} seconds...`;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                window.history.back(); // Redirect back to the previous page
            }
        }, 1000);
    </script>

</body>
</html>
