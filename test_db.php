<?php
// Test database connection
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'ncdsdb';

$conn = @new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    echo "Connection Error: " . $conn->connect_error;
} else {
    echo "Database Connection: SUCCESS";
}

// Close the connection
$conn->close();
?>
