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


$sql = "SELECT * FROM spare_parts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планирование запасных частей</title>
    <style>
     
    </style>
</head>
<body>
    <h1>Планирование запасных частей и расходных материалов</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Количество</th>
            <th>Необходимое количество</th>
            <th>Последнее обновление</th>
            <th>Поставщик</th>
            <th>Контактная информация</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . $row["required_quantity"] . "</td>";
                echo "<td>" . $row["last_updated"] . "</td>";
                echo "<td>" . $row["supplier"] . "</td>";
                echo "<td>" . $row["contact_info"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Записей не найдено</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <a href="add_spare_part.php">Добавить</a>
    <a href="index.php">Назад</a>
</body>
</html>