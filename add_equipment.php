<?php
session_start();


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); 
    exit();
}


$servername = "MySQL-8.0";
$username = "root";
$password = "";
$dbname = "guseb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}


$equipment_name = $conn->real_escape_string($_POST['equipment_name']);
$quantity = intval($_POST['quantity']);
$quality_check = $conn->real_escape_string($_POST['quality_check']);
$receipt_date = $conn->real_escape_string($_POST['receipt_date']);


$sql = "INSERT INTO equipment (name, quantity, quality_check, receipt_date) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siss", $equipment_name, $quantity, $quality_check, $receipt_date);

if ($stmt->execute()) {
    echo "Оборудование успешно добавлено.";
} else {
    echo "Ошибка при добавлении оборудования: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>