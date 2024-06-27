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


$userId = $_GET['id'];


$sql = "SELECT id, first_name, last_name, phone, role_id FROM users WHERE id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {

    header("Location: admin_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование пользователя</title>
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
    <h1>Редактирование пользователя</h1>
    <form action="update_user.php" method="post">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <label for="first_name">Имя:</label>
        <input type="text" id="first_name" name="first_name" value="<?= $user['first_name'] ?>" required>
        <label for="last_name">Фамилия:</label>
        <input type="text" id="last_name" name="last_name" value="<?= $user['last_name'] ?>" required>
        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="phone" value="<?= $user['phone'] ?>" required>
        <label for="role">Роль:</label>
        <select id="role" name="role">

            <option value="1" <?php if ($user['role_id'] == 1) echo 'selected' ?>>Администратор</option>
            <option value="2" <?php if ($user['role_id'] == 2) echo 'selected' ?>>Пользователь</option>

        </select>
        <input type="submit" value="Сохранить изменения">
    </form>
    <a href="admin_users.php">Назад к списку пользователей</a>
</body>
</html>