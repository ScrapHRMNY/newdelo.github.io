<?php
session_start();


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_role'] !== 1) {
    header("Location: login.php"); 
    exit();
}


$servername = "MySQL-8.0";
$username = "root";
$password = "";
$dbname = "guseb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}


$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $quantity = intval($_POST['quantity']);
    $required_quantity = intval($_POST['required_quantity']);
    $last_updated = date("Y-m-d", strtotime($_POST['last_updated']));
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $contact_info = $conn->real_escape_string($_POST['contact_info']);


    $sql = "UPDATE spare_parts SET name='$name', quantity=$quantity, required_quantity=$required_quantity, last_updated='$last_updated', supplier='$supplier', contact_info='$contact_info' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Запасная часть обновлена успешно";
        header("Location: spare_parts.php"); 
        exit();
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}


$sql = "SELECT * FROM spare_parts WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать запасную часть</title>
    <style>

    </style>
</head>
<body>
    <h1>Редактировать запасную часть</h1>
    <form action="edit_spare_part.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Название:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>
        <label for="quantity">Количество:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required><br>
        <label for="required_quantity">Необходимое количество:</label>
        <input type="number" id="required_quantity" name="required_quantity" value="<?php echo $row['required_quantity']; ?>"><br>
        <label for="last_updated">Последнее обновление:</label>
        <input type="date" id="last_updated" name="last_updated" value="<?php echo $row['last_updated']; ?>"><br>
        <label for="supplier">Поставщик:</label>
        <input type="text" id="supplier" name="supplier" value="<?php echo $row['supplier']; ?>"><br>
        <label for="contact_info">Контактная информация:</label>
        <input type="text" id="contact_info" name="contact_info" value="<?php echo $row['contact_info']; ?>"><br>
        <input type="submit" value="Обновить запасную часть">
    </form>
</body>
</html>