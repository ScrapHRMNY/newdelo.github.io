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


if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 1 && $_SESSION['user_role'] != 2)) {
    die("Доступ запрещен. У вас нет прав администратора.");
}


$sql = "SELECT * FROM breakdown_reports ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial_scale=1.0">
    <title>Уведомления для администратора</title>
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
    <h1>Уведомления для администратора</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Описание проблемы</th>
            <th>Тип оборудования</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["equipment_type"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td><a href='admin_notifications.php?delete_id=" . $row["id"] . "'>Удалить</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Нет заявок на устранение сбоев</td></tr>";
        }
        ?>
    </table>

    <?php
    if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_sql = "DELETE FROM breakdown_reports WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<p>Заявка успешно удалена.</p>";
        } else {
            echo "<p>Ошибка при удалении заявки: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
    $conn->close();
    ?>
<a href="index.php">Выйти</a>
</body>
</html>