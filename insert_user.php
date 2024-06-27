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


$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$patronymic = $conn->real_escape_string($_POST['patronymic']); 
$phone = $conn->real_escape_string($_POST['phone']);
$role = $conn->real_escape_string($_POST['role']);
$passport_series = $conn->real_escape_string($_POST['passport_series']);
$passport_number = $conn->real_escape_string($_POST['passport_number']);
$birth_date = $conn->real_escape_string($_POST['birth_date']);
$password = $conn->real_escape_string($_POST['password']); 


$password_hash = password_hash($password, PASSWORD_DEFAULT); 


$registration_date = date('Y-m-d H:i:s');


$sql = "INSERT INTO users (first_name, last_name, patronymic, phone, role_id, password, passport_series, passport_number, birth_date, registration_date) 
VALUES ('$first_name', '$last_name', '$patronymic', '$phone', '$role', '$password_hash', '$passport_series', '$passport_number', '$birth_date', '$registration_date')";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_users.php");
} else {
    echo "Ошибка при добавлении пользователя: " . $conn->error;
}

$conn->close();
?>