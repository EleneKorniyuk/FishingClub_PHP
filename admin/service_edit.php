<?php
/**
 * Форма редактирования услуги
 * Загружает существующие данные и сохраняет изменения
*/

require '../config/database.php';
require '../includes/functions.php';
requireAuth();

$type = $_GET['type'] ?? 'fishing';
$table = $type == 'fishing' ? 'fishing_services' : 'comfort_services';

// ===== ПОЛУЧАЕМ ID УСЛУГИ =====
// Из URL берем параметр id
// (int) - преобразуем в число для безопасности
$id = (int)($_GET['id'] ?? 0);

// ===== Получаем текущие данные =====
$stmt = $pdo->prepare("SELECT * FROM $table WHERE id=?");
$stmt->execute([$id]);
$service = $stmt->fetch();

if(!$service) {
    die('Услуга не найдена');
}

$errors = [];

// ===== Сохранение изменений =====
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(empty($_POST['name'])) $errors[] = "Введите название";
    
    if(empty($errors)) {
        $name = trim($_POST['name']);
        $desc = trim($_POST['description'] ?? '');
        $details = trim($_POST['details'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $active = isset($_POST['active']) ? 1 : 0;
        $sort = (int)($_POST['sort'] ?? 0);
        
        // Для fishing_services в БД есть поле details, для comfort_services - нет
        if($type == 'fishing') {
            $sql = "UPDATE $table SET 
                    service_name=?, description=?, details=?, price_info=?, is_active=?, sort_order=? 
                    WHERE id=?";
            $pdo->prepare($sql)->execute([$name, $desc, $details, $price, $active, $sort, $id]);
        } else {
            $sql = "UPDATE $table SET 
                    service_name=?, description=?, price_info=?, is_active=?, sort_order=? 
                    WHERE id=?";
            $pdo->prepare($sql)->execute([$name, $desc, $price, $active, $sort, $id]);
        }
        
        redirect("admin/services.php?type=$type");
    }
}

include '../includes/header.php';
?>

<h2>Редактировать услугу</h2>

<?php if(!empty($errors)): ?>
    <?php showError($errors); ?>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Название</label>
        <input type="text" name="name" value="<?php echo e($service['service_name']); ?>" required>
    </div>
    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" rows="3"><?php echo e($service['description']); ?></textarea>
    </div>
    
    <!-- Поле Детали только для рыболовных услуг -->
    <?php if($type == 'fishing'): ?>
    <div class="form-group">
        <label>Детали</label>
        <textarea name="details" rows="3"><?php echo e($service['details'] ?? ''); ?></textarea>
    </div>
    <?php endif; ?>
    
    <div class="form-group">
        <label>Цена</label>
        <input type="text" name="price" value="<?php echo e($service['price_info']); ?>">
    </div>
    <div class="form-group">
        <label>Порядок</label>
        <input type="number" name="sort" value="<?php echo $service['sort_order']; ?>">
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="active" <?php echo $service['is_active'] ? 'checked' : ''; ?>> 
            Активно
        </label>
    </div>
    <button type="submit" class="btn">Сохранить</button>
    <a href="services.php?type=<?php echo $type; ?>" class="btn">Отмена</a>
</form>

<?php include '../includes/footer.php'; ?>