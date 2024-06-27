<?php
session_start();


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
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

if (isset($_GET['id'])) {
    $userId = $_GET['id'];


    $sql = "DELETE FROM users WHERE id = $userId";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_users.php");
    } else {
        echo "Ошибка при удалении пользователя: " . $conn->error;
    }
} else {
    header("Location: admin_users.php");
    exit();
}

$conn->close();
?>