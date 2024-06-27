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


$sql = "SELECT * FROM services";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Услуги</title>
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
    <h1>Наши услуги</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="service-item">
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>Цена: <?php echo $row['price']; ?></p>
                <?php if ($userIsLoggedIn): ?>
                    <form action="order_service.php" method="post">
                        <input type="hidden" name="service_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Заказать услугу</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Услуг пока нет.</p>
    <?php endif; ?>
</section>
</body>
</html>

<?php
$conn->close();
?>