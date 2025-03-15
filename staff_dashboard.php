<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: admin_login.php");
    exit();
}
?>
<h1>Welcome, Staff!</h1>
<a href="logout.php">Logout</a>
