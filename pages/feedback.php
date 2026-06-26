<?php
/**
 * Форма обратной связи (отзывы)
 * Пользователь оставляет имя, контакты и сообщение - сохраняется в БД
*/

require '../config/database.php';
require '../includes/functions.php';
include '../includes/header.php';

$msg = '';  // Сообщение об успехе
$errors = [];   // Сообщение об ошибке

// ===== Обработка формы =====
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Валидация
    $errors = [];
    
    if(empty($_POST['name'])) $errors[] = "Введите имя";
    if(empty($_POST['email'])) $errors[] = "Введите email";
    if(empty($_POST['phone'])) $errors[] = "Введите телефон";
    if(empty($_POST['message'])) $errors[] = "Введите сообщение";
    
    if(empty($errors) && !validateEmail($_POST['email'])) {
        $errors[] = 'Некорректный email';
    }
    
    if(empty($errors)) {
        // Сохраняем в БД
        $stmt = $pdo->prepare("INSERT INTO feedback (name, email, phone, message, section_id) VALUES (?, ?, ?, ?, 1)");
        $stmt->execute([
            trim($_POST['name']),
            trim($_POST['email']),
            trim($_POST['phone']),
            trim($_POST['message'])
        ]);
        
        $msg = 'Спасибо за отзыв! Он появится после модерации.';
    }
}
?>

<h2>Оставить отзыв</h2>

<?php if($msg): ?>
    <?php showSuccess($msg); ?>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <?php showError($errors); ?>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Имя *</label>
        <input type="text" name="name" required value="<?php echo e($_POST['name'] ?? ''); ?>">
    </div>
    <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email" required value="<?php echo e($_POST['email'] ?? ''); ?>">
    </div>
    <div class="form-group">
        <label>Телефон *</label>
        <input type="tel" name="phone" onkeyup="checkPhone(this)" required 
               value="<?php echo e($_POST['phone'] ?? ''); ?>">
    </div>
    <div class="form-group">
        <label>Ваш отзыв *</label>
        <textarea name="message" rows="4" required><?php echo e($_POST['message'] ?? ''); ?></textarea>
    </div>
    <button type="submit" class="btn">Отправить</button>
</form>

<?php include '../includes/footer.php'; ?>