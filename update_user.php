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


$userId = $_POST['id'];
$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$phone = $conn->real_escape_string($_POST['phone']);
$role = $conn->real_escape_string($_POST['role']);


$sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', phone = '$phone', role_id = '$role' WHERE id = $userId";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_users.php");
} else {
    echo "Ошибка при обновлении данных пользователя: " . $conn->error;
}

$conn->close();
?>