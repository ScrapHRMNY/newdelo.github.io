<?php
session_start();

$servername = "MySQL-8.0";
$username = "root"; 
$password = ""; 
$dbname = "guseb"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 1) {
    header("Location: /login.php"); 
    exit();
}


$serviceId = $_GET['id'];


$sql = "DELETE FROM services WHERE id = $serviceId";

if ($conn->query($sql) === TRUE) {

    header("Location: admin_panel.php");
    exit();
} else {
    echo "Ошибка при удалении услуги: " . $conn->error;
}

$conn->close();
?>