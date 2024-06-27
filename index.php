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


$sql = "SELECT font_id FROM settings WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$fontId = $row['font_id'];


$sql = "SELECT name FROM fonts WHERE id = $fontId";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$fontName = $row['name'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Новое дело</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #admin-panel {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            width: 200px;
            height: 300px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
            z-index: 100;
        }
    </style>
    <script>
        function toggleAdminPanel() {
            var adminPanel = document.getElementById('admin-panel');
            if (adminPanel.style.display === 'none') {  
                adminPanel.style.display = 'block';
            } else {
                adminPanel.style.display = 'none';
            }
        }
    </script>
    <?php

$sql = "SELECT font_id FROM settings WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$fontId = $row['font_id'];


$sql = "SELECT name FROM fonts WHERE id = $fontId";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$fontName = $row['name'];
?>
<style>
body {
    font-family: '<?php echo $fontName; ?>', sans-serif;
}
</style>
</head>
<body>
<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
    <div id="admin-menu" class="hidden">
        <ul>
            <li><a href="admin_panel.php">Панель управления</a></li>
            <li><a href="admin_users.php">Пользователи</a></li>
            <li><a href="admin_settings.php">Настройки</a></li>
            <li><a href="admin_notifications.php">Уведомления</a></li>
            <li><a href="admin_monitoring.php">Мониторинг</a></li>
            <li><a href="logout.php">Выйти</a></li>
        </ul>
    </div>
<?php endif; ?>
<header>
    <a href="index.php"><img src="img/New.png" alt=""></a>
    <nav class="nav-container">
        <a href="services.php">Услуги</a>
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
    <section id="about">
        <h1 style="text-align: center;">О нашей компании</h1>
        <p style="color: black; text-align: center;">ООО "Новое дело" – это динамично развивающаяся компания, которая специализируется на предоставлении комплекса услуг в сфере информационных технологий и образовательных программ. Компания занимается следующими видами деятельности:

            Образовательные услуги:
            
            Разработка и проведение образовательных курсов по различным аспектам информационных технологий, включая программирование, администрирование, сетевое и системное обеспечение.
            
            Организация обучения для начинающих и опытных специалистов, нацеленного на повышение квалификации и профессионального роста.
            
            Проведение вебинаров, семинаров и мастер-классов по актуальным темам в области IT.
            
            Администрирование компьютерных сетей:
            
            Услуги по настройке, поддержке и мониторингу локальных и глобальных компьютерных сетей.
            
            Внедрение и сопровождение систем безопасности, обеспечивающих защиту информации и стабильность работы сетей.
            
            Разработка программного обеспечения:
            
            Создание и внедрение специализированного программного обеспечения для корпоративных клиентов и образовательных учреждений.
            
            Разработка мобильных приложений, веб-сервисов и систем автоматизации бизнес-процессов.
            
            Графический дизайн:
            
            Создание фирменного стиля, логотипов, презентаций и маркетинговых материалов для компаний и проектов.
            
            Разработка пользовательских интерфейсов (UI) и опыта взаимодействия с пользователем (UX) для программных продуктов и веб-ресурсов.
            
            Информационное обеспечение производственной деятельности:
            
            Контроль и оперативное устранение сбоев в работе оборудования и программного обеспечения.
            
            Разработка инструкций и технической документации, сопровождение внедренных программ и программных средств.
            
            Обучение сотрудников приемам и навыкам работы с компьютерами и внедряемыми программными средствами.
            
            Компания "Новое дело" стремится к созданию инновационных решений, которые помогают клиентам повысить эффективность их деятельности, а также к развитию образовательных программ, направленных на подготовку квалифицированных IT-специалистов.</p>
    </section>
    <section id="news">
        <h1>Новости</h1>
        <article>
            <img src="news1.jpg" alt="Новость 1">
            <h2>Название новости</h2>
            <p>Описание новости...</p>
            <a href="news-detail.html">Подробнее</a>
        </article>
    </section>
    <footer id="contact">
        <p>Контакты: email@example.com, +7 (123) 456-78-90</p>
        <nav>
            <ul >
                <a href="aboutus.php" style="text-decoration: none; color: black; font-size: 20px;">О нас</a>
                <a href="#news" style="text-decoration: none; color: black;font-size: 20px; text-align: center;">Новости</a>
                <a href="#contact" style="text-decoration: none; color: black;font-size: 20px;">Контакты</a>
            </ul>
        </nav>
    </footer>
    <script>
    function toggleAdminPanel() {
        var adminPanel = document.getElementById('admin-panel');
        if (adminPanel.style.display === 'none') {
            adminPanel.style.display = 'block';
        } else {
            adminPanel.style.display = 'none';
        }
    }
    </script>
</body>
</html>