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


$name = $conn->real_escape_string($_POST['name']);
$version = $conn->real_escape_string($_POST['version']);
$description = $conn->real_escape_string($_POST['description']);
$installation_date = $conn->real_escape_string($_POST['installation_date']);
$source = $conn->real_escape_string($_POST['source']);
$last_update = $conn->real_escape_string($_POST['last_update']);
$author = $conn->real_escape_string($_POST['author']);


$sql = "INSERT INTO software_archive (name, version, description, installation_date, source, last_update, author) VALUES ('$name', '$version', '$description', '$installation_date', '$source', '$last_update', '$author')";

if ($conn->query($sql) === TRUE) {
    echo "Новое программное средство добавлено успешно";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>