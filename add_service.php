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
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить услугу</title>
    <style>
    
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: 98%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Добавить услугу</h1>
        <form action="insert_service.php" method="post">
            <label for="name">Название:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="description">Описание:</label>
            <textarea id="description" name="description" required></textarea><br>
            <label for="price">Цена:</label>
            <input type="text" id="price" name="price" required><br>
            <button type="submit">Добавить услугу</button>
        </form>
        <a href="admin_panel.php">Назад к управлению услугами</a>
    </div>
</body>
</html>