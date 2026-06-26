<?php
/**
 * Шапка сайта (header)
 * Подключается на всех страницах
 * Использует функции из functions.php
*/

// Подключаем настройки и функции (если ещё не подключены)
require_once __DIR__ . '/../config/settings.php';
require_once __DIR__ . '/functions.php';

// Базовый путь для ссылок (используем константу из settings.php)
$base_path = BASE_URL;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo SITE_NAME; ?></title>
    <!-- Подключаем стили -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/style.css">
</head>
<body>
    <!-- Шапка сайта -->
    <header>
        <div class="container">
            <h1><?php echo SITE_NAME; ?></h1>
            
            <!-- Меню навигации -->
            <nav>
                <ul>
                    <!-- Ссылки для всех посетителей -->
                    <li><a href="<?php echo $base_path; ?>index.php">Главная</a></li>
                    <li><a href="<?php echo $base_path; ?>pages/services.php">Услуги</a></li>
                    <li><a href="<?php echo $base_path; ?>pages/events.php">Мероприятия</a></li>
                    <li><a href="<?php echo $base_path; ?>pages/reservation.php">Забронировать</a></li>
                    <li><a href="<?php echo $base_path; ?>pages/feedback.php">Отзывы</a></li>
                    
                    <?php 
                    // Проверяем, авторизован ли пользователь
                    // Если да - показываем ссылку на админку и выход
                    // Если нет - показываем вход
                    if(isset($_SESSION['user_id'])): 
                    ?>
                        <li><a href="<?php echo $base_path; ?>admin/index.php">Админка</a></li>
                        <li><a href="<?php echo $base_path; ?>logout.php">Выход (<?php echo e($_SESSION['user_login'] ?? 'Админ'); ?>)</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo $base_path; ?>login.php">Вход</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <!-- Начало основного содержимого -->
    <main class="container">