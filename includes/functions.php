<?php
/**
 * Вспомогательные функции
 * Эти функции используются на разных страницах
*/

/**
 * Безопасный вывод текста (защита от XSS)
*/
function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Показывает сообщение об успехе
*/
function showSuccess($message) {
    echo '<div class="success-message">' . $message . '</div>';
}

/**
 * Показывает сообщение об ошибке
*/
function showError($message) {
    if(is_array($message)) {
        $message = implode('<br>', $message);
    }
    echo '<div class="error-message">' . $message . '</div>';
}

/**
 * Перенаправление на другую страницу
*/
function redirect($url) {
    header('Location: ' . BASE_URL . $url); // const работает
    exit;
}

/**
 * Проверка авторизации (для админки)
*/
function requireAuth() {
    if(!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

/**
 * Форматирование даты
*/
function formatDate($date) {
    if(empty($date)) return '';
    return date('d.m.Y', strtotime($date));
}

/**
 * Форматирование даты и времени
*/
function formatDateTime($datetime) {
    if(empty($datetime)) return '';
    return date('d.m.Y H:i', strtotime($datetime));
}

/**
 * Валидация email
*/
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}