<?php
session_start();


$servername = "MySQL-8.0";
$username = "root";
$password = "";
$dbname = "guseb";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /login.php"); 
    exit();
}


$serviceId = $_POST['service_id'];


$sqlService = "SELECT name, description FROM services WHERE id = $serviceId";
$resultService = $conn->query($sqlService);

if ($resultService->num_rows > 0) {
    $rowService = $resultService->fetch_assoc();
    $serviceName = $rowService['name'];
    $serviceDescription = $rowService['description'];
    $userId = $_SESSION['user_id'];

    $sql = "INSERT INTO orders (user_id, service_id, service_name, service_description) VALUES ('$userId', '$serviceId', '$serviceName', '$serviceDescription')";

    if ($conn->query($sql) === TRUE) {
        header("Location: services.php");
        exit();
    } else {
        echo "Ошибка при оформлении заказа: " . $conn->error;
    }
} else {
    echo "Услуга не найдена.";
}

$conn->close();
?>