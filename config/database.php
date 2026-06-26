<?php
/**
 * Подключение к базе данных
 * Используется PDO для работы с БД MySQL в PHP
 * Настройки: из settings.php
*/

//  Константа PHP, которая содержит полный путь к папке с текущим файлом
require_once __DIR__ . '/settings.php';

try {
    // Создаем подключение к БД с использованием констант из settings.php
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", 
        DB_USER, 
        DB_PASS
    );
    
    // Показывать ошибки
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}