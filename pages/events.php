<?php
/**
 * Страница мероприятий с поиском
 * Можно искать по названию и описанию
*/

require '../config/database.php';
require '../includes/functions.php';
include '../includes/header.php';

// ===== Обработка поискового запроса =====
// trim - убираем пробелы по краям
$search = trim($_GET['search'] ?? '');

// Если есть поисковый запрос
if($search) {
    // Ищем в названии И описании (оператор OR)
    // %$search% - ищем вхождение строки в любом месте
    $stmt = $pdo->prepare("
        SELECT * FROM events 
        WHERE is_active=1 
        AND (event_name LIKE ? OR description LIKE ?) 
        ORDER BY sort_order
    ");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    // Если поиска нет - показываем все
    $stmt = $pdo->query("SELECT * FROM events WHERE is_active=1 ORDER BY sort_order");
}

$events = $stmt->fetchAll();
?>

<h2>Мероприятия</h2>

<!-- Форма поиска -->
<div class="search-form">
    <form method="GET">
        <input type="text" name="search" placeholder="Поиск по названию..." 
               value="<?php echo e($search); ?>">
        <button type="submit" class="btn">Найти</button>
        
        <?php if($search): ?>
        <a href="events.php" class="btn">Сбросить</a>
        <?php endif; ?>
    </form>
</div>

<!-- Результаты -->
<?php if(count($events) == 0): ?>
    <?php if($search): ?>
        <p>По запросу "<?php echo e($search); ?>" ничего не найдено.</p>
    <?php else: ?>
        <p>Мероприятия пока не добавлены.</p>
    <?php endif; ?>
<?php else: ?>
    <div class="events-page-grid">
        <?php foreach($events as $e): ?>
        <div class="event-card">
            <h3><?php echo e($e['event_name']); ?></h3>
            <p><?php echo nl2br(e($e['description'])); ?></p>
            <p><strong>Расписание:</strong> <?php echo e($e['timetable_info']); ?></p>
            <?php if($e['price_info']): ?>
            <p><strong>Цена:</strong> <?php echo e($e['price_info']); ?></p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>