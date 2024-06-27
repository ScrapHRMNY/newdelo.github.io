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


if (isset($_POST['check_network'])) {

    $site_url = "https://cms2.loc";
    $site_result = @fopen($site_url, "r") ? 'up' : 'down';


    $network_result = is_network_up() ? 'up' : 'down'; 

  
    echo "<h2>Результаты проверки:</h2>";
    echo "<p>Статус сайта: $site_result</p>";
    echo "<p>Статус сети: $network_result</p>";
}

$conn->close();

function is_network_up() {
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мониторинг работы сайта и сети</title>
</head>
<body>
    <h1>Мониторинг работы сайта и сети</h1>
    <form action="" method="post">
        <button type="submit" name="check_network">Провести проверку</button>
    </form>
    <a href="index.php">Назад</a>
</body>
</html>