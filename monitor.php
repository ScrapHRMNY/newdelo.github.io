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


$site_url = "https://cms2.loc";
$site_result = @fopen($site_url, "r") ? 'up' : 'down';


$network_result = is_network_up() ? 'up' : 'down'; 


$sql = "INSERT INTO network_monitoring (site_status, network_status) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $site_result, $network_result);
$stmt->execute();

$stmt->close();
$conn->close();

function is_network_up() {

}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мониторинг работы сайта и сети</title>
</head>
<body>
    <h1>Мониторинг работы сайта и сети</h1>
    <p>Проверка работоспособности сайта и сети выполнена.</p>
</body>
</html>