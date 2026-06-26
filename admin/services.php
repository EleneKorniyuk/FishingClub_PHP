<?php
/**
 * Управление услугами (рыболовные и комфорт)
 * Показывает список с возможностью удаления и перехода к редактированию
*/

require '../config/database.php';
require '../includes/functions.php';
requireAuth(); // Проверка авторизации

// Определяем тип услуги
$type = $_GET['type'] ?? 'fishing';
$table = $type == 'fishing' ? 'fishing_services' : 'comfort_services';
$title = $type == 'fishing' ? 'Рыболовные услуги' : 'Услуги комфорта';

// ===== УДАЛЕНИЕ =====
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM $table WHERE id=?")->execute([$id]);
    redirect("admin/services.php?type=$type");
}

// Получаем список услуг
$services = $pdo->query("SELECT * FROM $table ORDER BY sort_order")->fetchAll();

include '../includes/header.php';
?>

<h2><?php echo $title; ?></h2>

<!-- Навигация -->
<a href="index.php" class="btn btn-small">← Назад</a>
<a href="services.php?type=fishing" class="btn <?php echo $type=='fishing'?'active':''; ?>">Рыбалка</a>
<a href="services.php?type=comfort" class="btn <?php echo $type=='comfort'?'active':''; ?>">Комфорт</a>
<a href="service_add.php?type=<?php echo $type; ?>" class="btn">+ Добавить</a>

<!-- Таблица -->
<table class="admin-table services-table">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Цена</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    <?php foreach($services as $s): ?>
    <tr>
        <td><?php echo $s['id']; ?></td>
        <td><?php echo e($s['service_name']); ?></td>
        <td><?php echo e($s['price_info']); ?></td>
        <td><?php echo $s['is_active'] ? 'Активно' : 'Выключено'; ?></td>
        <td class="actions">
            <a href="service_edit.php?type=<?php echo $type; ?>&id=<?php echo $s['id']; ?>" class="btn-small">Изменить</a>
            <a href="?type=<?php echo $type; ?>&delete=<?php echo $s['id']; ?>" 
               class="btn-small delete" 
               onclick="return confirm('Удалить?')">Удалить</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>