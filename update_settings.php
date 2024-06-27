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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (isset($_POST['font_id']) && is_numeric($_POST['font_id'])) {
        $fontId = $_POST['font_id'];
        $sql = "UPDATE settings SET font_id = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $fontId);

        if ($stmt->execute()) {
            echo "Настройки успешно обновлены";
        } else {
            echo "Ошибка при обновлении настроек: " . $stmt->error;
        }
    } else {
        echo "Некорректный ID шрифта";
    }

    header("Location: admin_settings.php");
    exit();
}
?>