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


$userIsLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true;
$userId = $userIsLoggedIn ? $_SESSION['user_id'] : null;


$sql = "SELECT * FROM courses ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Курсы</title>
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
    <h1>Последние добавленные курсы</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="course-item">
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo mb_substr($row['description'], 0, 200) . '...'; ?> <a href="course_details.php?id=<?php echo $row['id']; ?>">Читать далее</a></p>
                <?php if ($userIsLoggedIn && $userId == $row['user_id']): ?>
                    <a href="edit_course.php?id=<?php echo $row['id']; ?>">Редактировать курс</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Курсы пока не добавлены.</p>
    <?php endif; ?>

    <?php if ($userIsLoggedIn): ?>
        <h2 style="text-align: center;">Создать новый курс</h2>
        <form action="create_course.php" method="post">
            <div class="form-group" style="text-align: center; margin-bottom:20px; font-size:20px">
                <label for="course_name">Название курса:</label>
                <input type="text" id="course_name" name="course_name" required style="width: 100%;">
            </div>
            <div class="form-group" style="text-align: center; margin-bottom:20px; font-size:20px">
                <label for="course_description">Описание курса:</label>
                <textarea id="course_description" name="course_description" rows="4" required style="width: 100%;"></textarea>
            </div>
            <div style="text-align: center;"><button type="submit">Создать курс</button></div>
        </form>
    <?php endif; ?>
</section>
</body>
</html>

<?php
$conn->close();
?>