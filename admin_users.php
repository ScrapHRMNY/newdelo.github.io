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


$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление пользователями</title>
    <style>
      
        table { border-collapse: collapse; width: 50%; margin: 20px auto; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Управление пользователями</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Действия</th>
            <th>Редактирование</th>
        </tr>
        <?php foreach ($users as $user): ?>
<tr>
    <td><?= $user['id'] ?></td>
    <td><?= $user['first_name'] ?></td>
    <td><?= $user['last_name'] ?></td>
    <td><?= $user['phone'] ?></td>
    <td><?= $user['role_id'] ?></td>
    <td>
        <a href="edit_user.php?id=<?= $user['id'] ?>">Редактировать</a> |
        <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
    </td>
</tr>
<?php endforeach; ?>
    </table>
    <a href="add_user.php">Добавить пользователя</a>
    <a href="index.php">Выйти</a>
</body>
</html>