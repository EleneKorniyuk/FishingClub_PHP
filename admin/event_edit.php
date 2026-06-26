<?php
/**
 * Форма редактирования мероприятия
 * Что делает:
 * 1. Проверяет авторизацию
 * 2. Получает ID мероприятия из URL (?id=5)
 * 3. Загружает текущие данные из БД
 * 4. Показывает форму с заполненными данными
 * 5. Сохраняет изменения при отправке формы
*/

require '../config/database.php';
require '../includes/functions.php';
requireAuth();

// ===== ПОЛУЧАЕМ ID МЕРОПРИЯТИЯ =====
// Из URL берем параметр id
// (int) - преобразуем в число для безопасности
$id = (int)($_GET['id'] ?? 0);

// Если ID = 0 (не передан или не число) - ошибка
if($id == 0) {
    die('Ошибка: не указан ID мероприятия');
}

// ===== ЗАГРУЖАЕМ ДАННЫЕ ИЗ БАЗЫ =====
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);

// Получаем одну запись в виде массива
$event = $stmt->fetch();

// Если запись не найдена
if(!$event) {
    die('Мероприятие не найдено в базе данных');
}

$errors = [];

// ===== ОБРАБОТКА СОХРАНЕНИЯ =====
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(empty($_POST['name'])) $errors[] = "Введите название";
    
    if(empty($errors)) {
        $name = trim($_POST['name']);
        $desc = trim($_POST['description'] ?? '');
        $timetable = trim($_POST['timetable'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $active = isset($_POST['active']) ? 1 : 0;
        $sort = (int)($_POST['sort'] ?? 0);
        
        $sql = "UPDATE events SET 
                event_name=?, description=?, timetable_info=?, price_info=?, is_active=?, sort_order=? 
                WHERE id=?";
        $pdo->prepare($sql)->execute([$name, $desc, $timetable, $price, $active, $sort, $id]);
        
        redirect('admin/events.php');
    }
}

include '../includes/header.php';
?>

<h2>Редактировать мероприятие</h2>

<?php if(!empty($errors)): ?>
    <?php showError($errors); ?>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Название мероприятия</label>
        <input type="text" name="name" value="<?php echo e($event['event_name']); ?>" required>
    </div>
    
    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" rows="3"><?php echo e($event['description']); ?></textarea>
    </div>
    
    <div class="form-group">
        <label>Расписание</label>
        <input type="text" name="timetable" value="<?php echo e($event['timetable_info']); ?>">
    </div>
    
    <div class="form-group">
        <label>Цена</label>
        <input type="text" name="price" value="<?php echo e($event['price_info']); ?>">
    </div>
    
    <div class="form-group">
        <label>Порядок сортировки</label>
        <input type="number" name="sort" value="<?php echo $event['sort_order']; ?>">
    </div>
    
    <div class="form-group">
        <label>
            <input type="checkbox" name="active" <?php echo $event['is_active'] ? 'checked' : ''; ?>> 
            Активно
        </label>
    </div>
    
    <button type="submit" class="btn">Сохранить</button>
    <a href="events.php" class="btn">Отмена</a>
</form>

<?php include '../includes/footer.php'; ?>