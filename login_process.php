<?php
session_start(); 

$servername = "MySQL-8.0";
$username = "root";
$password = "";
$dbname = "guseb";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $passwordInput = $_POST["password"];


    $sql = "SELECT * FROM users WHERE (last_name = ? OR phone = ?) AND role_id IN (1, 2)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($user['role_id'] == 1) { 
            if (password_verify($passwordInput, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['logged_in'] = true;
                $_SESSION['user_role'] = $user['role_id'];
                header("Location: /index.php");
                exit(); 
            } else {
                echo "Неверный пароль";
            }
        } elseif ($user['role_id'] == 2) { 
            if (password_verify($passwordInput, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['logged_in'] = true; 
                $_SESSION['user_role'] = $user['role_id']; 
                header("Location: /index.php"); 
                exit(); 
            } else {
                echo "Неверный пароль";
            }
        }
    } else {
        echo "Пользователь не найден";
    }

    $stmt->close();
    $conn->close();
}
?>