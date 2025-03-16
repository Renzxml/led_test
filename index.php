<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp32_control";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch individual LED states
$led1_state = 0;
$led2_state = 0;
$led3_state = 0;

$result = $conn->query("SELECT * FROM led_control WHERE led_number = 1");
if ($row = $result->fetch_assoc()) $led1_state = $row["state"];

$result = $conn->query("SELECT * FROM led_control WHERE led_number = 2");
if ($row = $result->fetch_assoc()) $led2_state = $row["state"];

$result = $conn->query("SELECT * FROM led_control WHERE led_number = 3");
if ($row = $result->fetch_assoc()) $led3_state = $row["state"];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESP32 LED Control</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ESP32 LED Control</h1>
    
    <div class="led-controls">
        <!-- LED 1 -->
        <form action="update_led.php" method="POST">
            <input type="hidden" name="led_number" value="1">
            <input type="hidden" name="state" value="<?= $led1_state == 1 ? 0 : 1 ?>">
            <button class="<?= $led1_state == 1 ? 'on' : 'off' ?>" type="submit">
                LED 1: <?= $led1_state == 1 ? 'ON' : 'OFF' ?>
            </button>
        </form>

        <!-- LED 2 -->
        <form action="update_led.php" method="POST">
            <input type="hidden" name="led_number" value="2">
            <input type="hidden" name="state" value="<?= $led2_state == 1 ? 0 : 1 ?>">
            <button class="<?= $led2_state == 1 ? 'on' : 'off' ?>" type="submit">
                LED 2: <?= $led2_state == 1 ? 'ON' : 'OFF' ?>
            </button>
        </form>

        <!-- LED 3 -->
        <form action="update_led.php" method="POST">
            <input type="hidden" name="led_number" value="3">
            <input type="hidden" name="state" value="<?= $led3_state == 1 ? 0 : 1 ?>">
            <button class="<?= $led3_state == 1 ? 'on' : 'off' ?>" type="submit">
                LED 3: <?= $led3_state == 1 ? 'ON' : 'OFF' ?>
            </button>
        </form>
    </div>
</body>
</html>
