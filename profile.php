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
    header("Location: /login.php"); 
    exit();
}


$userId = $_SESSION['user_id'];


$sql = "SELECT * FROM users WHERE id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Пользователь не найден.";
    exit();
}


$sqlOrders = "SELECT services.name, services.description, services.price FROM services 
              JOIN orders ON services.id = orders.service_id 
              WHERE orders.user_id = $userId";
$resultOrders = $conn->query($sqlOrders);

$orders = [];
if ($resultOrders->num_rows > 0) {
    while($row = $resultOrders->fetch_assoc()) {
        $orders[] = $row;
    }
}


$sqlCourses = "SELECT * FROM courses WHERE user_id = $userId";
$resultCourses = $conn->query($sqlCourses);

$courses = [];
if ($resultCourses->num_rows > 0) {
    while($row = $resultCourses->fetch_assoc()) {
        $courses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Профиль пользователя</title>
</head>
<body>
<header>
    <a href="index.php"><img src="img/New.png" alt=""></a>
    <nav>
        <a href="services.php">Услуги</a>
        <a href="">Новости</a>
        <a href="courses.php">Курсы</a>
        <a href="profile.php">Мой профиль</a>

        <a href="breakdown_control.php">Контроль и устранение сбоев</a>
        <a href="training_courses.php">Обучение</a>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
            <a href="archive.php">Архив программных средств</a>
            <a href="spare_parts.php">Планирование запасных частей и учет</a>
            <a href="equipment_receipt.php">Обеспечение приема оборудования</a>
        <?php endif; ?>
        <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
            <a href="login.html">Вход</a>
        <?php else: ?>
            <a href="logout.php">Выход</a>
        <?php endif; ?>
    </nav>
</header>
<section>
    <h1>Профиль пользователя</h1>
    <p style="color:black"><strong>Имя:</strong> <?php echo $user['first_name']; ?></p>
    <p style="color:black"><strong>Фамилия:</strong> <?php echo $user['last_name']; ?></p>
    <p style="color:black"><strong>Отчество:</strong> <?php echo $user['patronymic']; ?></p>
    <p style="color:black"><strong>Серия паспорта:</strong> <?php echo $user['passport_series']; ?></p>
    <p style="color:black"><strong>Номер паспорта:</strong> <?php echo $user['passport_number']; ?></p>
    <p style="color:black"><strong>Телефон:</strong> <?php echo $user['phone']; ?></p>
    <p style="color:black"><strong>Дата рождения:</strong> <?php echo $user['birth_date']; ?></p>
    <p style="color:black"><strong>Роль:</strong> <?php echo $user['role_id'] == 1 ? 'Администратор' : 'Пользователь'; ?></p>

   
    <?php if (!empty($orders)): ?>
        <h2>Заказанные услуги</h2>
        <ul>
            <?php foreach ($orders as $order): ?>
                <li><?php echo $order['name']; ?> - <?php echo $order['description']; ?> (<?php echo $order['price']; ?> руб.)</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if (!empty($courses)): ?>
        <h2>Созданные курсы</h2>
        <ul>
            <?php foreach ($courses as $course): ?>
                <li><?php echo $course['name']; ?> (<?php echo $course['start_date']; ?> - <?php echo $course['end_date']; ?>) - <?php echo $course['price']; ?> руб.</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
</body>
</html>