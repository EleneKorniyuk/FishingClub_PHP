<?php
/**
 * Форма добавления новой услуги
 * Работает для обоих типов: рыболовные и комфорт
 * с валидацией
*/

require '../config/database.php';
require '../includes/functions.php';
requireAuth();

$type = $_GET['type'] ?? 'fishing';
$table = $type == 'fishing' ? 'fishing_services' : 'comfort_services';

$errors = [];

// ===== Обработка формы =====
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Простая валидация
    if(empty($_POST['name'])) $errors[] = "Введите название";
    if(empty($_POST['price'])) $errors[] = "Введите цену";
    
    if(empty($errors)) {
        $name = trim($_POST['name']);
        $desc = trim($_POST['description'] ?? '');
        $details = trim($_POST['details'] ?? '');
        $price = trim($_POST['price']);
        $active = isset($_POST['active']) ? 1 : 0;
        $sort = (int)($_POST['sort'] ?? 0);
        
        // Для рыболовных услуг в БД есть поле details, для комфорта - нет
        if($type == 'fishing') {
            $sql = "INSERT INTO $table (service_name, description, details, price_info, is_active, sort_order, section_id) 
                    VALUES (?, ?, ?, ?, ?, ?, 2)";
            $pdo->prepare($sql)->execute([$name, $desc, $details, $price, $active, $sort]);
        } else {
            $sql = "INSERT INTO $table (service_name, description, price_info, is_active, sort_order, section_id) 
                    VALUES (?, ?, ?, ?, ?, 2)";
            $pdo->prepare($sql)->execute([$name, $desc, $price, $active, $sort]);
        }
        
        redirect("admin/services.php?type=$type");
    }
}

include '../includes/header.php';
?>

<h2>Добавить услугу</h2>

<?php if(!empty($errors)): ?>
    <?php showError($errors); ?>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Название *</label>
        <input type="text" name="name" required 
               value="<?php echo e($_POST['name'] ?? ''); ?>">
    </div>
    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" rows="3"><?php echo e($_POST['description'] ?? ''); ?></textarea>
    </div>
    
    <!-- Поле Детали только для рыболовных услуг -->
    <?php if($type == 'fishing'): ?>
    <div class="form-group">
        <label>Детали</label>
        <textarea name="details" rows="3"><?php echo e($_POST['details'] ?? ''); ?></textarea>
    </div>
    <?php endif; ?>
    
    <div class="form-group">
        <label>Цена *</label>
        <input type="text" name="price" required 
               value="<?php echo e($_POST['price'] ?? ''); ?>">
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
    <a href="services.php?type=<?php echo $type; ?>" class="btn">Отмена</a>
</form>

<?php include '../includes/footer.php'; ?>