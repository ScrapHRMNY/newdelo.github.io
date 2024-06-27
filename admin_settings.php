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


$sql = "SELECT * FROM settings";
$result = $conn->query($sql);


$sqlFonts = "SELECT * FROM fonts";
$resultFonts = $conn->query($sqlFonts);


$settingsHtml = '';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['name'] === 'font') {
            $settingsHtml .= '<div>';
            $settingsHtml .= '<label for="font_id">Шрифт:</label>';
            $settingsHtml .= '<select name="font_id">';
            while($rowFont = $resultFonts->fetch_assoc()) {
                $selected = ($rowFont['id'] == $row['font_id']) ? ' selected' : '';
                $settingsHtml .= '<option value="' . $rowFont['id'] . '"' . $selected . '>' . $rowFont['name'] . '</option>';
            }
            $settingsHtml .= '</select>';
            $settingsHtml .= '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Настройки сайта</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"],
        select {
            width: 98%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <h1>Настройки сайта</h1>
    
    <form action="update_settings.php" method="post">
     
        <?php echo $settingsHtml; ?>
        <input type="submit" value="Сохранить настройки">
    </form>
    <a href="index.php">Выйти</a>
</body>
</html>