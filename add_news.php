<?php

$servername = "MySQL-8.0"; 
$username = "root"; 
$password = ""; 
$dbname = "guseb";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image'];

 
    $imagePath = '';
    if (!empty($image['tmp_name'])) {
        $imagePath = 'uploads/' . $image['name'];
        move_uploaded_file($image['tmp_name'], $imagePath);
    }


    $stmt = $pdo->prepare("INSERT INTO news (title, content, image_url, publication_date) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$title, $content, $imagePath]);

    header('Location: index.php');
}
?>