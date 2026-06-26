<?php
/**
 * Страница со списком ВСЕХ услуг
 * Включает: рыболовные услуги + услуги комфорта
 * Реализована пагинация (разбиение на страницы, постраничный вывод)
*/

require '../config/database.php';
require '../includes/functions.php';
include '../includes/header.php';

// ===== Пагинация =====
// ===== Определяем текущую страницу =====
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Защита: номер страницы не может быть меньше 1
if($page < 1) $page = 1;

// Настройки пагинации
$limit = ITEMS_PER_PAGE;  // Используем константу из settings.php
$offset = ($page - 1) * $limit;  // Сколько пропустить записей

// ===== Выбор типа услуг =====
$type = $_GET['type'] ?? 'fishing';

if($type == 'comfort') {
    $table = 'comfort_services';
    $title = 'Услуги комфорта';
} else {
    $table = 'fishing_services';
    $title = 'Рыболовные услуги';
}

// ===== Считаем записи для пагинации =====
$total = $pdo->query("SELECT COUNT(*) FROM $table WHERE is_active=1")->fetchColumn();
$pages = ceil($total / $limit);
if($pages < 1) $pages = 1;

// ===== Получаем записи =====
$services = $pdo->query("
    SELECT * FROM $table 
    WHERE is_active=1 
    ORDER BY sort_order 
    LIMIT $limit OFFSET $offset
")->fetchAll();
?>

<h2><?php echo $title; ?></h2>

<!-- Переключатель типов -->
<div style="margin-bottom: 20px;">
    <a href="?type=fishing" class="btn <?php echo $type=='fishing' ? 'active' : ''; ?>">
        Рыболовные услуги
    </a>
    <a href="?type=comfort" class="btn <?php echo $type=='comfort' ? 'active' : ''; ?>">
        Услуги комфорта
    </a>
</div>

<?php if(empty($services)): ?>
    <p>Услуги пока не добавлены.</p>
<?php else: ?>
    <div class="services-page-grid">
        <?php foreach($services as $s): ?>
        <div class="service-item">
            <h3><?php echo e($s['service_name']); ?></h3>
            <p><?php echo nl2br(e($s['description'])); ?></p>
            <p class="price"><strong>Цена:</strong> <?php echo e($s['price_info']); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Пагинация -->
<?php if($pages > 1): ?>
<div class="pagination">
    <?php for($i = 1; $i <= $pages; $i++): ?>
        <?php if($i == $page): ?>
            <span class="active"><?php echo $i; ?></span>
        <?php else: ?>
            <a href="?type=<?php echo $type; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>