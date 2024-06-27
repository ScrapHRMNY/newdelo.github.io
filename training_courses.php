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


if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 1 && $_SESSION['user_role'] != 2)) {
    die("Доступ запрещен. У вас нет прав администратора.");
}


$sql = "SELECT * FROM courses ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Систематическое обучение</title>
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
    <h1>Систематическое обучение</h1>
    <form action="training_courses.php" method="post">
        <label for="participant_name">Имя участника:</label>
        <input type="text" id="participant_name" name="participant_name" required>
        <br>
        <label for="participant_email">Email участника:</label>
        <input type="email" id="participant_email" name="participant_email" required>
        <br>
        <label for="selected_course">Выберите курс:</label>
        <select id="selected_course" name="selected_course" required>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            } else {
                echo "<option value=''>Нет доступных курсов</option>";
            }
            ?>
        </select>
        <br>
        <button type="submit" name="register">Зарегистрироваться</button>
    </form>

    <?php
  
    if (isset($_POST['register'])) {
        $participant_name = $_POST['participant_name'];
        $participant_email = $_POST['participant_email'];
        $selected_course = $_POST['selected_course'];


    }
    ?>
        <a href="index.php">Выйти</a>
</body>
</html>