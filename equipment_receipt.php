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


$sql = "SELECT id, name AS equipment_name, quantity, quality_check, receipt_date FROM equipment";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обеспечение приема оборудования, комплектующих и материалов</title>
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
    <h1>Обеспечение приема оборудования, комплектующих и материалов</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Название оборудования</th>
            <th>Количество</th>
            <th>Качество</th>
            <th>Дата приема</th>

        </tr>
        
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['equipment_name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['quality_check']; ?></td>
            <td><?php echo $row['receipt_date']; ?></td>

        </tr>
        <?php endwhile; ?>
    </table>
    <h2>Добавить новое оборудование</h2>
<form action="add_equipment.php" method="post">
    <label for="equipment_name">Название оборудования:</label>
    <input type="text" id="equipment_name" name="equipment_name" required><br><br>
    <label for="quantity">Количество:</label>
    <input type="number" id="quantity" name="quantity" required><br><br>
    <label for="quality_check">Качество:</label>
    <select id="quality_check" name="quality_check">
        <option value="passed">Пройдено</option>
        <option value="failed">Не пройдено</option>
    </select><br><br>
    <label for="receipt_date">Дата приема:</label>
    <input type="date" id="receipt_date" name="receipt_date" required><br><br>
    <input type="submit" value="Добавить">
</form>
<a href="index.php">Назад</a>
</body>
</html>