<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root'; // Change to your DB username
$db_pass = '';     // Change to your DB password
$db_name = 'sekgwari_db';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8
$conn->set_charset("utf8");
?>
