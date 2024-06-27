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


$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];


$sql = "INSERT INTO services (name, description, price) VALUES ('$name', '$description', '$price')";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_panel.php"); 
    exit();
} else {
    echo "Ошибка при добавлении услуги: " . $conn->error;
}

$conn->close();
?>