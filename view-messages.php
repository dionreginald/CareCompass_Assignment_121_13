<?php
// Include the database connection file
include('db.php');

// Get all contact messages
$sql = "SELECT * FROM contact_messages ORDER BY date_sent DESC";
$result = $conn->query($sql);

echo "<h1>Contact Messages</h1>";

if ($result->num_rows > 0) {
    // Display each message
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message'>";
        echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
        echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
        echo "<p><strong>Message:</strong> " . $row['message'] . "</p>";
        echo "<p><strong>Sent on:</strong> " . $row['date_sent'] . "</p>";
        echo "</div><hr>";
    }
} else {
    echo "No messages found!";
}

$conn->close();
?>
