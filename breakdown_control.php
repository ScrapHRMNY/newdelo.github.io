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


function submitBreakdownReport($conn, $description, $equipmentType) {
    $sql = "INSERT INTO breakdown_reports (description, equipment_type) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $description, $equipmentType);
    $stmt->execute();
    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $equipmentType = $_POST['equipment_type'];
    submitBreakdownReport($conn, $description, $equipmentType);
    echo "Заявка на устранение сбоя успешно отправлена.";
}
?>

<!DOCTYPE html>
<html lang="ru">
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"],
        select {
            width: 98%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
        }
    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контроль и устранение сбоев</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"],
        select {
            width: 98%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <h1>Форма для отправки заявки на устранение сбоя</h1>
    <form action="breakdown_control.php" method="post">
        <label for="description">Описание проблемы:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <label for="equipment_type">Тип оборудования или программного обеспечения:</label>
        <select id="equipment_type" name="equipment_type" required>
            <option value="">Выберите тип</option>
            <option value="компьютер">Компьютер</option>
            <option value="ноутбук">Ноутбук</option>
            <option value="сервер">Сервер</option>
            <option value="принтер">Принтер</option>
            <option value="программное обеспечение">Программное обеспечение</option>
        </select>
        <br>
        <button type="submit">Отправить</button>
        <a href="index.php">Выйти</a>
    </form>
</body>
</html>