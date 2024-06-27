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
include 'config.php';
include 'check_role.php';

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}


$stmt = $pdo->query('SELECT * FROM services');
$services = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Административная панель</title>
    <style>
   
        table { border-collapse: collapse; width: 50%; margin: 20px auto; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Управление услугами</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($services as $service): ?>
        <tr>
            <td><?= $service['id'] ?></td>
            <td><?= $service['name'] ?></td>
            <td><?= $service['description'] ?></td>
            <td><?= $service['price'] ?></td>
            <td>
                <a href="edit_service.php?id=<?= $service['id'] ?>">Редактировать</a> |
                <a href="delete_service.php?id=<?= $service['id'] ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="add_service.php">Добавить услугу</a>
    <a href="index.php">Выйти</a>
</body>
</html>