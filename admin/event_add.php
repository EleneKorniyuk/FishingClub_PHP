<?php
/**
 * Форма добавления мероприятия
 * Что делает:
 * 1. Проверяет, авторизован ли пользователь (админ)
 * 2. Показывает форму для ввода данных мероприятия
 * 3. Обрабатывает отправку формы и сохраняет в БД
*/

require '../config/database.php';
require '../includes/functions.php';
requireAuth();

$errors = [];

// ===== ОБРАБОТКА ОТПРАВКИ ФОРМЫ =====
// Проверяем, была ли нажата кнопка отправки (метод POST)
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(empty($_POST['name'])) $errors[] = "Введите название";
    
    if(empty($errors)) {
        $name = trim($_POST['name'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $timetable = trim($_POST['timetable'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $active = isset($_POST['active']) ? 1 : 0;
        $sort = (int)($_POST['sort'] ?? 0);
        
        $sql = "INSERT INTO events (event_name, description, timetable_info, price_info, is_active, sort_order, section_id) 
                VALUES (?, ?, ?, ?, ?, ?, 3)";
        $pdo->prepare($sql)->execute([$name, $desc, $timetable, $price, $active, $sort]);
        
        redirect('admin/events.php');
    }
}

include '../includes/header.php';
?>

<!-- ===== HTML-ФОРМА ДОБАВЛЕНИЯ ===== -->
<h2>Добавить мероприятие</h2>

<!-- Если была ошибка валидации - показываем -->
<?php if(!empty($errors)): ?>
    <?php showError($errors); ?>
<?php endif; ?>

<!-- Форма отправляется на эту же страницу методом POST -->
<form method="POST">
    <div class="form-group">
        <label>Название мероприятия *</label>
        <input type="text" name="name" required value="<?php echo e($_POST['name'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" rows="3"><?php echo e($_POST['description'] ?? ''); ?></textarea>
    </div>
    
    <div class="form-group">
        <label>Расписание</label>
        <input type="text" name="timetable" value="<?php echo e($_POST['timetable'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Цена</label>
        <input type="text" name="price" value="<?php echo e($_POST['price'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Порядок сортировки</label>
        <input type="number" name="sort" value="<?php echo $_POST['sort'] ?? 0; ?>">
    </div>
    
    <div class="form-group">
        <label>
            <input type="checkbox" name="active" checked> 
            Активно
        </label>
    </div>
    
    <button type="submit" class="btn">Сохранить</button>
    <a href="events.php" class="btn">Отмена</a>
</form>

<?php include '../includes/footer.php'; ?>