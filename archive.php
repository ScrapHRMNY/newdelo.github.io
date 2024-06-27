<?php
session_start();

// Данные для подключения к базе данных
$servername = "MySQL-8.0"; // Адрес сервера базы данных
$username = "root"; // Имя пользователя
$password = ""; // Пароль
$dbname = "guseb"; // Имя базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Запрос к базе данных для получения информации о программных средствах
$sql = "SELECT * FROM software_archive";
$result = $conn->query($sql);

// Проверка, является ли пользователь администратором
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 1) {
    echo "logged_in: " . (isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : 'не установлено') . "<br>";
    echo "user_role: " . (isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'не установлено') . "<br>";
    die("Доступ запрещен. Только администраторы могут просматривать эту страницу.");
}

// Проверка, является ли пользователь администратором
$isAdmin = false;
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) {
    $isAdmin = true;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Архив программных средств</title>
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
    <h1>Архив программных средств</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Версия</th>
            <th>Описание</th>
            <th>Дата установки</th>
            <th>Источник</th>
            <th>Последнее обновление</th>
            <th>Автор</th>
            <th>Действия</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["version"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["installation_date"] . "</td>";
                echo "<td>" . $row["source"] . "</td>";
                echo "<td>" . $row["last_update"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td><a href='edit.php?id=" . $row["id"] . "'>Редактировать</a> | <a href='delete.php?id=" . $row["id"] . "'>Удалить</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Записей не найдено</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <h2>Добавить новое программное средство</h2>
    <form action="add_software.php" method="post">
        <label for="name">Название:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="version">Версия:</label>
        <input type="text" id="version" name="version"><br>
        <label for="description">Описание:</label>
        <textarea id="description" name="description"></textarea><br>
        <label for="installation_date">Дата установки:</label>
        <input type="date" id="installation_date" name="installation_date"><br>
        <label for="source">Источник:</label>
        <input type="text" id="source" name="source"><br>
        <label for="last_update">Последнее обновление:</label>
        <input type="date" id="last_update" name="last_update"><br>
        <label for="author">Автор:</label>
        <input type="text" id="author" name="author"><br>
        <input type="submit" value="Добавить программное средство">
    </form>
</body>
</html>