<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain'); // Ensures correct response format

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp32_control";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch each LED state explicitly
$led1_state = 0;
$led2_state = 0;
$led3_state = 0;

$query1 = $conn->query("SELECT state FROM led_control WHERE led_number = 1");
if ($query1 && $row = $query1->fetch_assoc()) {
    $led1_state = (int)$row['state'];
}

$query2 = $conn->query("SELECT state FROM led_control WHERE led_number = 2");
if ($query2 && $row = $query2->fetch_assoc()) {
    $led2_state = (int)$row['state'];
}

$query3 = $conn->query("SELECT state FROM led_control WHERE led_number = 3");
if ($query3 && $row = $query3->fetch_assoc()) {
    $led3_state = (int)$row['state'];
}

$conn->close();

// Output the LED states as a comma-separated string for ESP32
echo "$led1_state,$led2_state,$led3_state";
?>
