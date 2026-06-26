<?php
/**
 * Управление мероприятиями
 * Список с возможностью удаления и с поиском
*/

require '../config/database.php';
require '../includes/functions.php';
requireAuth();

// Удаление
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM events WHERE id=?")->execute([$id]);
    redirect('admin/events.php');
}

// Поиск
$search = trim($_GET['search'] ?? '');
if($search) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE event_name LIKE ? OR description LIKE ? ORDER BY sort_order");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM events ORDER BY sort_order");
}
$events = $stmt->fetchAll();

include '../includes/header.php';
?>

<h2>Мероприятия</h2>

<a href="index.php" class="btn btn-small">← Назад</a>
<a href="event_add.php" class="btn">+ Добавить</a>

<!-- Поиск -->
<form method="GET" style="display:inline-block; margin-left:20px;">
    <input type="text" name="search" placeholder="Поиск..." value="<?php echo e($search); ?>">
    <button type="submit" class="btn-small">Найти</button>
    <?php if($search): ?>
        <a href="events.php" class="btn-small">Сбросить</a>
    <?php endif; ?>
</form>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Расписание</th>
        <th>Цена</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    <?php foreach($events as $e): ?>
    <tr>
        <td><?php echo $e['id']; ?></td>
        <td><?php echo e($e['event_name']); ?></td>
        <td><?php echo e($e['timetable_info']); ?></td>
        <td><?php echo e($e['price_info']); ?></td>
        <td><?php echo $e['is_active'] ? 'Активно' : 'Выключено'; ?></td>
        <td class="actions">
            <a href="event_edit.php?id=<?php echo $e['id']; ?>" class="btn-small">Изменить</a>
            <a href="?delete=<?php echo $e['id']; ?>" 
               class="btn-small delete" 
               onclick="return confirm('Удалить?')">Удалить</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>