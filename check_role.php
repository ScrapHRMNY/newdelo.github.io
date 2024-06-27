<?php
session_start(); // Начало сессии

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1;
}

function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true;
}
?>