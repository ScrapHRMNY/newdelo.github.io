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


$newsId = 1; 


$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $newsId); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $news = $result->fetch_assoc();
} else {
    echo "Новость не найдена";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($news['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="index.php"><img src="img/New.png" alt=""></a>
    <nav>
        <a href="services.php" >Услуги</a>
        <a href="news.php">Новости</a>
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
<main>
    <h1><?php echo htmlspecialchars($news['title']); ?></h1>
    <p><strong>Дата публикации:</strong> <?php echo htmlspecialchars($news['created_at']); ?></p>
    <?php if (!empty($news['image_url'])): ?>
        <img src="<?php echo htmlspecialchars($news['image_url']); ?>" alt="Изображение новости">
    <?php endif; ?>
    <p><?php echo htmlspecialchars($news['content']); ?></p>
    <a href="index.php">Назад</a>
</main>
<footer id="contact">
        <p>Контакты: email@example.com, +7 (123) 456-78-90</p>
        <nav>
            <ul >
                <a href="aboutus.php" style="text-decoration: none; color: black; font-size: 20px;">О нас</a>
                <a href="news.php" style="text-decoration: none; color: black;font-size: 20px; text-align: center;">Новости</a>
                <a href="#contact" style="text-decoration: none; color: black;font-size: 20px;">Контакты</a>
            </ul>
        </nav>
    </footer>
</body>
</html>