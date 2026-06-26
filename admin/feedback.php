<?php
/**
 * Управление отзывами (обратная связь) с фильтрацией по статусу
 * Можно менять статус отзыва и удалять
*/

require '../config/database.php';
require '../includes/functions.php';
requireAuth();

// ===== УДАЛЕНИЕ =====
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM feedback WHERE id=?")->execute([$id]);
    redirect('admin/feedback.php');
}

// ===== ИЗМЕНЕНИЕ СТАТУСА =====
if(isset($_POST['status'])) {
    $id = (int)$_POST['id'];
    $status = $_POST['status'];
    $pdo->prepare("UPDATE feedback SET status=? WHERE id=?")->execute([$status, $id]);
    redirect('admin/feedback.php');
}

// ===== ФИЛЬТРАЦИЯ ПО СТАТУСУ =====
// Получаем фильтр из URL
$filter = $_GET['filter'] ?? '';  // По умолчанию пусто (все отзывы)

// Формируем SQL в зависимости от фильтра
$sql = "SELECT * FROM feedback";

if($filter) {
    $sql .= " WHERE status = '$filter'";
}
$sql .= " ORDER BY submission_date DESC";

$feedback = $pdo->query($sql)->fetchAll();

$status_names = [
    'new' => 'Новый',
    'in_progress' => 'В работе',
    'answered' => 'Отвечен',
    'closed' => 'Закрыт'
];

include '../includes/header.php';
?>

<h2>Отзывы</h2>

<a href="index.php" class="btn btn-small">← Назад</a>

<!-- Фильтры -->
<div class="filter-bar" style="margin:20px 0;">
    <a href="?" class="btn-small <?php echo !$filter ? 'active' : ''; ?>">Все</a>
    <a href="?filter=new" class="btn-small <?php echo $filter=='new' ? 'active' : ''; ?>">Новые</a>
    <a href="?filter=in_progress" class="btn-small <?php echo $filter=='in_progress' ? 'active' : ''; ?>">В работе</a>
    <a href="?filter=answered" class="btn-small <?php echo $filter=='answered' ? 'active' : ''; ?>">Отвеченные</a>
    <a href="?filter=closed" class="btn-small <?php echo $filter=='closed' ? 'active' : ''; ?>">Закрытые</a>
</div>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Телефон</th>
        <th>Сообщение</th>
        <th>Дата</th>
        <th>Статус</th>
        <th>Удалить</th>
    </tr>
    
    <?php foreach($feedback as $f): ?>
    <tr>
        <td><?php echo $f['id']; ?></td>
        <td><?php echo e($f['name']); ?></td>
        <td><?php echo e($f['email']); ?></td>
        <td><?php echo e($f['phone']); ?></td>
        <td>
            <?php 
            $message = $f['message'];
            // Берем первые 7 слов
            $words = explode(' ', $message);
            $short = implode(' ', array_slice($words, 0, 7));
            echo e($short);
            echo (count($words) > 7) ? '...' : '';
            ?>
            <!-- Подчеркнутый текст "детали" -->
            <a href="javascript:void(0);" 
               onclick='showFullMessage(<?php echo json_encode([
                   'name' => $f['name'],
                   'email' => $f['email'],
                   'phone' => $f['phone'],
                   'date' => formatDate($f['submission_date']),
                   'status' => $status_names[$f['status']] ?? $f['status'],
                   'message' => nl2br(e($f['message']))
               ]); ?>)'
               style="text-decoration: underline; color: #3498db; margin-left: 5px; cursor: pointer;">
                детали
            </a>
        </td>
        <td><?php echo formatDate($f['submission_date']); ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
                <select name="status" onchange="this.form.submit()">
                    <?php foreach($status_names as $key => $label): ?>
                        <option value="<?php echo $key; ?>" <?php echo $f['status']==$key?'selected':''; ?>>
                            <?php echo $label; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </td>
        <td>
            <a href="?delete=<?php echo $f['id']; ?>" 
               class="btn-small delete" 
               onclick="return confirm('Удалить?')">Удалить</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if(count($feedback) == 0): ?>
    <p>Отзывы не найдены.</p>
<?php endif; ?>

<script>
function showFullMessage(data) {
    // Формируем текст сообщения для confirm
    var messageText = 
        "ПОЛНОЕ СООБЩЕНИЕ\n" +
        "================\n\n" +
        "От: " + data.name + "\n" +
        "Email: " + data.email + "\n" +
        "Телефон: " + data.phone + "\n" +
        "Дата: " + data.date + "\n" +
        "Статус: " + data.status + "\n\n" +
        "Текст сообщения:\n" +
        "----------------\n" +
        data.message;
    
    // Показываем в confirm
    confirm(messageText);
}
</script>

<?php include '../includes/footer.php'; ?>