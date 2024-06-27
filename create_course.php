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


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if (isset($_POST['course_name']) && isset($_POST['course_description'])) {
        $course_name = $conn->real_escape_string($_POST['course_name']);
        $course_description = $conn->real_escape_string($_POST['course_description']);
        $user_id = $_SESSION['user_id'];

     
        $sql = "INSERT INTO courses (name, description, user_id) VALUES ('$course_name', '$course_description', '$user_id')";

        if ($conn->query($sql) === TRUE) {
            echo "Курс успешно создан";
        } else {
            echo "Ошибка при создании курса: " . $conn->error;
        }
    } else {
        echo "Не все необходимые поля были заполнены.";
    }
}

$conn->close();
?>