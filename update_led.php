<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp32_control";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $led_number = intval($_POST["led_number"]);
    $state = intval($_POST["state"]);

    $stmt = $conn->prepare("UPDATE led_control SET state = ? WHERE led_number = ?");
    $stmt->bind_param("ii", $state, $led_number);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php"); // Redirect back after update
exit();
?>
