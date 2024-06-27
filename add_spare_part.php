<?php
session_start();


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 1) {
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $conn->real_escape_string($_POST['name']);
    $quantity = intval($_POST['quantity']);
    $required_quantity = intval($_POST['required_quantity']);
    $last_updated = date("Y-m-d", strtotime($_POST['last_updated']));
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $contact_info = $conn->real_escape_string($_POST['contact_info']);


    $sql = "INSERT INTO spare_parts (name, quantity, required_quantity, last_updated, supplier, contact_info) VALUES ('$name', $quantity, $required_quantity, '$last_updated', '$supplier', '$contact_info')";

    if ($conn->query($sql) === TRUE) {
        echo "Новая запасная часть добавлена успешно";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить новую запасную часть</title>
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
    <h1>Добавить новую запасную часть</h1>
    <form action="add_spare_part.php" method="post">
        <label for="name">Название:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="quantity">Количество:</label>
        <input type="number" id="quantity" name="quantity" required><br>
        <label for="required_quantity">Необходимое количество:</label>
        <input type="number" id="required_quantity" name="required_quantity"><br>
        <label for="last_updated">Последнее обновление:</label>
        <input type="date" id="last_updated" name="last_updated"><br>
        <label for="supplier">Поставщик:</label>
        <input type="text" id="supplier" name="supplier"><br>
        <label for="contact_info">Контактная информация:</label>
        <input type="text" id="contact_info" name="contact_info"><br>
        <input type="submit" value="Добавить запасную часть">
    </form>
    <a href="spare_parts.php">Назад</a>
</body>
</html>