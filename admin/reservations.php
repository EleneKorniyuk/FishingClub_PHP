<?php
/**
 * Управление бронированиями
 * Показывает список заявок с фильтрацией по статусу
 * Можно менять статус заявки
*/

require '../config/database.php';
require '../includes/functions.php';
requireAuth();

// ===== Изменение статуса =====
if(isset($_POST['status'])) {
    $id = (int)$_POST['id'];
    $status = $_POST['status'];
    $pdo->prepare("UPDATE reservations SET status=? WHERE id=?")->execute([$status, $id]);
    redirect('admin/reservations.php');
}

// ===== Фильтр по статусу =====
// Получаем фильтр из URL
$filter = $_GET['filter'] ?? '';  // Текущий фильтр

// Формируем SQL в зависимости от фильтра
$sql = "SELECT * FROM reservations";
if($filter) {
    $sql .= " WHERE status='$filter'";
}
$sql .= " ORDER BY created_at DESC";  // Сначала новые

$reservations = $pdo->query($sql)->fetchAll();

// Для отображения типа
$types = [
    'fishing' => 'Рыбалка',
    'comfort' => 'Комфорт',
    'event' => 'Мероприятие'
];

// Для отображения статуса
$statuses = [
    'new' => 'Новая',
    'confirmed' => 'Подтверждена',
    'cancelled' => 'Отменена'
];

include '../includes/header.php';
?>

<h2>Бронирования</h2>

<a href="index.php" class="btn btn-small">← Назад</a>

<!-- Фильтры -->
<div class="filter-bar" style="margin:20px 0;">
    <a href="?" class="btn-small <?php echo !$filter?'active':''; ?>">Все</a>
    <a href="?filter=new" class="btn-small <?php echo $filter=='new'?'active':''; ?>">Новые</a>
    <a href="?filter=confirmed" class="btn-small <?php echo $filter=='confirmed'?'active':''; ?>">Подтвержденные</a>
    <a href="?filter=cancelled" class="btn-small <?php echo $filter=='cancelled'?'active':''; ?>">Отмененные</a>
</div>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Телефон</th>
        <th>Тип</th>
        <th>Дата</th>
        <th>Статус</th>
        <th>Детали</th>
    </tr>
    <?php foreach($reservations as $r): ?>
    <tr>
        <td><?php echo $r['id']; ?></td>
        <td><?php echo e($r['customer_name']); ?></td>
        <td><?php echo e($r['customer_phone']); ?></td>
        <td><?php echo $types[$r['reservation_type']] ?? $r['reservation_type']; ?></td>
        <td><?php echo formatDate($r['desired_date']); ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                <select name="status" onchange="this.form.submit()">
                    <?php foreach($statuses as $key => $label): ?>
                        <option value="<?php echo $key; ?>" <?php echo $r['status']==$key?'selected':''; ?>>
                            <?php echo $label; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </td>
        <td>
            <!-- Подчеркнутый текст "детали" -->
            <a href="javascript:void(0);" 
               onclick='showBookingDetails(<?php echo json_encode([
                   'name' => $r['customer_name'],
                   'phone' => $r['customer_phone'],
                   'email' => $r['customer_email'] ?? 'не указан',
                   'type' => $types[$r['reservation_type']] ?? $r['reservation_type'],
                   'date' => formatDate($r['desired_date']),
                   'created' => formatDateTime($r['created_at']),
                   'requests' => $r['special_requests'] ?? 'нет',
                   'status' => $statuses[$r['status']] ?? $r['status']
               ]); ?>)'
               style="text-decoration: underline; color: #3498db; cursor: pointer;">
                детали
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<script>
function showBookingDetails(data) {
    // Формируем текст сообщения для confirm
    var messageText = 
        "ДЕТАЛИ БРОНИРОВАНИЯ\n" +
        "===================\n\n" +
        "Имя: " + data.name + "\n" +
        "Телефон: " + data.phone + "\n" +
        "Email: " + data.email + "\n" +
        "Тип: " + data.type + "\n" +
        "Желаемая дата: " + data.date + "\n" +
        "Дата заявки: " + data.created + "\n" +
        "Статус: " + data.status + "\n\n" +
        "Особые пожелания:\n" +
        "-----------------\n" +
        data.requests;
    
    // Показываем в confirm
    confirm(messageText);
}
</script>

<?php include '../includes/footer.php'; ?>