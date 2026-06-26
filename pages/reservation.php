<?php
/**
 * Форма бронирования - Добавляет данные в таблицу reservations с проверкой
 * Пользователь выбирает тип услуги, конкретную услугу, дату и оставляет контакты
*/

require '../config/database.php';
require '../includes/functions.php';
include '../includes/header.php';

// ===== Получаем списки для выпадающих списков =====
$fishing = $pdo->query("SELECT id, service_name FROM fishing_services WHERE is_active=1")->fetchAll();
$comfort = $pdo->query("SELECT id, service_name FROM comfort_services WHERE is_active=1")->fetchAll();
$events = $pdo->query("SELECT id, event_name FROM events WHERE is_active=1")->fetchAll();

// ===== Обработка отправки формы =====
$errors = [];
$msg = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Простая валидация
    $errors = [];
    
    if(empty($_POST['name'])) $errors[] = "Введите имя";
    if(empty($_POST['phone'])) $errors[] = "Введите телефон";
    if(empty($_POST['type'])) $errors[] = "Выберите тип бронирования";
    if(empty($_POST['entity_id'])) $errors[] = "Выберите услугу";
    if(empty($_POST['date'])) $errors[] = "Выберите дату";
    
    $email = trim($_POST['email'] ?? '');
    if($email && !validateEmail($email)) {
        $errors[] = 'Некорректный email';
    }
    
    if(empty($errors)) {
        
        // Преобразуем тип бронирования в формат базы данных
        $type = $_POST['type'];
        
        // Маппинг типов для базы данных
        $type_map = [
            'fishing' => 'fishing_service',
            'comfort' => 'comfort_service',
            'event' => 'event'
        ];
        
        $db_type = $type_map[$type] ?? $type;
        
        // Определяем section_id в зависимости от типа
        $section_id = 2; // по умолчанию для услуг
        if($type == 'event') {
            $section_id = 3; // для мероприятий
        }
        
        // Сохраняем в БД
        $sql = "INSERT INTO reservations 
                (customer_name, customer_phone, customer_email, reservation_type, entity_id, section_id, desired_date, special_requests, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'new')";
        
        $pdo->prepare($sql)->execute([
            trim($_POST['name']),
            trim($_POST['phone']),
            $email,
            $db_type,
            (int)$_POST['entity_id'],
            $section_id,
            $_POST['date'],
            trim($_POST['requests'] ?? '')
        ]);
        
        $msg = 'Заявка принята! Мы свяжемся с вами.';
    }
}
?>

<h2>Забронировать</h2>

<?php if($msg): ?>
    <?php showSuccess($msg); ?>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <?php showError($errors); ?>
<?php endif; ?>

<form method="POST" id="reservationForm">
    <div class="form-group">
        <label>Имя *</label>
        <input type="text" name="name" required value="<?php echo e($_POST['name'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Телефон *</label>
        <input type="tel" name="phone" onkeyup="checkPhone(this)" required 
               value="<?php echo e($_POST['phone'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo e($_POST['email'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Тип бронирования *</label>
        <select name="type" id="type" onchange="updateList()" required>
            <option value="">Выберите тип</option>
            <option value="fishing" <?php echo ($_POST['type'] ?? '') == 'fishing' ? 'selected' : ''; ?>>Рыболовные услуги</option>
            <option value="comfort" <?php echo ($_POST['type'] ?? '') == 'comfort' ? 'selected' : ''; ?>>Услуги комфорта</option>
            <option value="event" <?php echo ($_POST['type'] ?? '') == 'event' ? 'selected' : ''; ?>>Мероприятия</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Услуга/мероприятие *</label>
        <select name="entity_id" id="entity" required>
            <option value="">Сначала выберите тип</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Дата *</label>
        <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required 
               value="<?php echo e($_POST['date'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Особые пожелания</label>
        <textarea name="requests" rows="3"><?php echo e($_POST['requests'] ?? ''); ?></textarea>
    </div>
    
    <button type="submit" class="btn">Отправить заявку</button>
</form>

<script>
// Данные для выпадающих списков
var data = {
    fishing: <?php echo json_encode($fishing); ?>,
    comfort: <?php echo json_encode($comfort); ?>,
    event: <?php echo json_encode($events); ?>
};

// Функция обновления списка услуг
function updateList() {
    var type = document.getElementById('type').value;
    var select = document.getElementById('entity');
    select.innerHTML = '<option value="">Выберите</option>';
    
    if(data[type]) {
        for(var i = 0; i < data[type].length; i++) {
            var item = data[type][i];
            var name = item.service_name || item.event_name;
            select.innerHTML += '<option value="' + item.id + '">' + name + '</option>';
        }
    }
}

// При загрузке страницы восстанавливаем выбор (если была ошибка)
document.addEventListener('DOMContentLoaded', function() {
    if(document.getElementById('type').value) {
        updateList();
        <?php if(!empty($_POST['entity_id'])): ?>
        document.getElementById('entity').value = <?php echo (int)($_POST['entity_id'] ?? 0); ?>;
        <?php endif; ?>
    }
});
</script>

<?php include '../includes/footer.php'; ?>