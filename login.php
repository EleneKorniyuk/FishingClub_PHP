<?php
/**
 * Страница входа в админ-панель
 * Проверяет логин и пароль, создает сессию при успехе
 * ИСПОЛЬЗУЕТ password_verify() для проверки пароля
*/

// Подключаем базу данных и функции
require 'config/database.php';
require 'includes/functions.php';

// Проверяем: если пользователь уже вошел - отправляем в админку
if(isset($_SESSION['user_id'])) {
    redirect('admin/index.php');
}

// Переменная для ошибки
$error = '';

// Проверяем, была ли отправлена форма (метод POST)
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if(empty($login) || empty($password)) {
        $error = 'Введите логин и пароль';
    } else {
        // Ищем пользователя
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();
        
        // Проверяем пароль
        if($user && password_verify($password, $user['pass'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_login'] = $user['login'];
            redirect('admin/index.php');
        } else {
            $error = 'Неверный логин или пароль';
        }
    }
}

include 'includes/header.php';
?>

<h2>Вход для администратора</h2>

<?php if($error): ?>
    <?php showError($error); ?>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Логин:</label>
        <input type="text" name="login" required>
    </div>
    <div class="form-group">
        <label>Пароль:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" class="btn">Войти</button>
</form>

<?php include 'includes/footer.php'; ?>