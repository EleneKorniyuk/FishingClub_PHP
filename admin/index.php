<?php
/**
 * Главная страница админ-панели
 * Показывает статистику по всем разделам и быстрые действия
*/

require '../config/database.php';
require '../includes/functions.php';

// Проверяем авторизацию (если не авторизован — отправит на login.php)
requireAuth();

// ===== Собираем статистику =====
// COUNT(*) - считает количество записей
// Используем подготовленные запросы для безопасности
$stats = [
    'fishing' => $pdo->query("SELECT COUNT(*) FROM fishing_services")->fetchColumn(),
    'comfort' => $pdo->query("SELECT COUNT(*) FROM comfort_services")->fetchColumn(),
    'events' => $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn(),
    'reservations' => $pdo->query("SELECT COUNT(*) FROM reservations")->fetchColumn(),
    'new_reservations' => $pdo->query("SELECT COUNT(*) FROM reservations WHERE status='new'")->fetchColumn(),
    'feedback' => $pdo->query("SELECT COUNT(*) FROM feedback")->fetchColumn()
];

include '../includes/header.php';
?>

<h2>Панель управления</h2>
<p>Добро пожаловать, <strong><?php echo e($_SESSION['user_login'] ?? 'Администратор'); ?></strong>!</p>

<!-- Карточки статистики -->
<div class="dashboard-stats">
    <div class="stat-card">
        <h3>Рыболовные услуги</h3>
        <p class="stat-number"><?php echo $stats['fishing']; ?></p>
        <a href="services.php?type=fishing" class="btn-small">Управлять</a>
    </div>
    
    <div class="stat-card">
        <h3>Услуги комфорта</h3>
        <p class="stat-number"><?php echo $stats['comfort']; ?></p>
        <a href="services.php?type=comfort" class="btn-small">Управлять</a>
    </div>
    
    <div class="stat-card">
        <h3>Мероприятия</h3>
        <p class="stat-number"><?php echo $stats['events']; ?></p>
        <a href="events.php" class="btn-small">Управлять</a>
    </div>
    
    <div class="stat-card highlight">
        <h3>Бронирования</h3>
        <p class="stat-number"><?php echo $stats['reservations']; ?></p>
        <?php if($stats['new_reservations'] > 0): ?>
            <p style="font-weight: bold;">Новых: <?php echo $stats['new_reservations']; ?></p>
        <?php else: ?>
            <p>Новых: 0</p>
        <?php endif; ?>
        <a href="reservations.php" class="btn-small">Смотреть</a>
    </div>
    
    <div class="stat-card">
        <h3>Отзывы</h3>
        <p class="stat-number"><?php echo $stats['feedback']; ?></p>
        <a href="feedback.php" class="btn-small">Смотреть</a>
    </div>
</div>

<h3>Быстрые действия</h3>
<a href="service_add.php?type=fishing" class="btn">+ Рыболовная услуга</a>
<a href="service_add.php?type=comfort" class="btn">+ Услуга комфорта</a>
<a href="event_add.php" class="btn">+ Мероприятие</a>

<?php include '../includes/footer.php'; ?>