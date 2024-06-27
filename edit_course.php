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


if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}


$course_id = $_GET['id'];


$sql = "SELECT * FROM courses WHERE id = $course_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Курс не найден";
    exit;
}

$course = $result->fetch_assoc();


if ($course['user_id'] != $_SESSION['user_id']) {
    echo "У вас нет прав для редактирования этого курса";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $conn->real_escape_string($_POST['course_name']);
    $course_description = $conn->real_escape_string($_POST['course_description']);
    $start_date = $conn->real_escape_string($_POST['start_date']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    $price = $conn->real_escape_string($_POST['price']);


    $sql = "UPDATE courses SET name = '$course_name', description = '$course_description', start_date = '$start_date', end_date = '$end_date', price = '$price' WHERE id = $course_id";

    if ($conn->query($sql) === TRUE) {
        echo "Курс успешно отредактирован";
    } else {
        echo "Ошибка при редактировании курса: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Редактирование курса</title>
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
    <h1 >Редактирование курса</h1>
    <form action="edit_course.php?id=<?php echo $course_id; ?>" method="post">
        <label for="course_name">Название курса:</label>
        <input type="text" id="course_name" name="course_name" value="<?php echo $course['name']; ?>" required>
        <label for="course_description">Описание курса:</label>
        <textarea id="course_description" name="course_description" rows="4" required><?php echo $course['description']; ?></textarea>
        <label for="start_date">Дата начала:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $course['start_date']; ?>" required>
        <label for="end_date">Дата окончания:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $course['end_date']; ?>" required>
        <label for="price">Цена:</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo $course['price']; ?>" required>
        <button type="submit">Сохранить изменения</button>
    </form>
    <a href="courses.php">Назад</a>
</body>
</html>