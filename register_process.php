<?php
$servername = "MySQL-8.0";
$username = "root";
$password = "";
$dbname = "guseb";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $last_name = $_POST["last_name"];
    $first_name = $_POST["first_name"];
    $patronymic = $_POST["patronymic"];
    $passport_series = $_POST["passport_series"];
    $passport_number = $_POST["passport_number"];
    $phone = $_POST["phone"];
    $birth_date = $_POST["birth_date"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); 

  
    if ($_POST["password"] !== $_POST["confirm_password"]) {
        echo "Пароли не совпадают";
    } else {
        $sql = "INSERT INTO users (last_name, first_name, patronymic, passport_series, passport_number, phone, birth_date, password, role_id, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 2, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $last_name, $first_name, $patronymic, $passport_series, $passport_number, $phone, $birth_date, $password);

        if ($stmt->execute()) {
            echo "Регистрация успешна!";
        } else {
            echo "Ошибка при регистрации: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>