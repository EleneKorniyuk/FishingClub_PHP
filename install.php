<?php
/**
 * Файл установки системы
 * ЗАПУСКАТЬ ТОЛЬКО ОДИН РАЗ!
 * После установки обязательно изменить $enabled на false
*/

// Переключатель установки
$enabled = false; // <-- поставить false после установки!

if(!$enabled) {
    die('Установка отключена. Для повторной установки измените $enabled в файле install.php');
}

require 'config/database.php';

try {
    // ===== СОЗДАНИЕ ТАБЛИЦЫ ПОЛЬЗОВАТЕЛЕЙ =====
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(50) NOT NULL UNIQUE,
        pass VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // ===== СОЗДАНИЕ АДМИНИСТРАТОРА =====
    $login = 'admin';
    $password = 'admin123';
    
    // Шифруем пароль (безопасно!)
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Удаляем старого админа если есть (чтобы не было дублей)
    $pdo->exec("DELETE FROM users WHERE login='admin'");
    
    // Добавляем нового админа
    $stmt = $pdo->prepare("INSERT INTO users (login, pass) VALUES (?, ?)");
    $stmt->execute([$login, $hash]);
    
    // Показываем результат
    echo "<h2>✓ Установка завершена успешно!</h2>";
    echo "<p><strong>Логин:</strong> admin</p>";
    echo "<p><strong>Пароль:</strong> admin123</p>";
    echo "<p><a href='login.php' class='btn'>Войти в админ-панель</a></p>";
    echo "<hr>";
    echo "<p style='color:red'><strong>⚠ ВАЖНО:</strong> Откройте файл install.php и измените <code>\$enabled = true</code> на <code>\$enabled = false</code></p>";
    echo "<p style='color:red'>Это защитит ваш сайт от повторной установки!</p>";
    
} catch(PDOException $e) {
    die("Ошибка установки: " . $e->getMessage());
}