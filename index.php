<?php
/**
 * Главная страница сайта
 * Показывает приветствие, 3 услуги и 3 мероприятия
*/

require 'config/database.php';      // Подключаем БД
require 'includes/functions.php';   // Подключаем функции
include 'includes/header.php';      // Шапка сайта

// ===== Получаем 3 активные услуги =====
// is_active=1 - только активные
// ORDER BY sort_order - сортируем по порядку
// LIMIT 3 - только 3 записи
$services = $pdo->query("
    SELECT * FROM fishing_services 
    WHERE is_active=1 
    ORDER BY sort_order 
    LIMIT 3
")->fetchAll();

// ===== Получаем 3 активных мероприятия =====
$events = $pdo->query("
    SELECT * FROM events 
    WHERE is_active=1 
    ORDER BY sort_order 
    LIMIT 3
")->fetchAll();
?>

<!-- Блок-приветствие -->
<section class="hero">
    <h2>Добро пожаловать в <?php echo SITE_NAME; ?>!</h2>
    <p>Лучшее место для рыбалки и отдыха на природе</p>
    <a href="pages/reservation.php" class="btn">Забронировать сейчас</a>
</section>

<!-- Блок услуг -->
<section class="features">
    <h2>Наши услуги</h2>
    <div class="services-grid">
        <?php 
        // Цикл по всем полученным услугам
        foreach($services as $s): 
        ?>
        <div class="service-card">
            <!-- Используем функцию e() для безопасного вывода -->
            <h3><?php echo e($s['service_name']); ?></h3>
            <p><?php echo e($s['description']); ?></p>
            <p class="price"><?php echo e($s['price_info']); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    <a href="pages/services.php" class="btn">Все услуги</a>
</section>

<!-- Блок мероприятий -->
<section class="events-section">
    <h2>Ближайшие мероприятия</h2>
    <div class="events-grid">
        <?php foreach($events as $e): ?>
        <div class="event-item">
            <h3><?php echo e($e['event_name']); ?></h3>
            <p><?php echo e($e['description']); ?></p>
            <p><strong>Расписание:</strong> <?php echo e($e['timetable_info']); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    <a href="pages/events.php" class="btn">Все мероприятия</a>
</section>

<?php include 'includes/footer.php'; ?>