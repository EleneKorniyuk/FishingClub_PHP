<?php
/**
 * Подвал сайта (footer)
 * Закрывает тег main, добавляет footer и подключает JS
*/

$base_path = BASE_URL;
?>

    </main> <!-- Закрываем main -->
    
    <!-- Подвал сайта -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Все права защищены.</p>
            <p>Экзаменационная работа по дисциплине "Серверные технологии разработки Web-сайтов"</p>
        </div>
    </footer>
    
    <!-- Подключаем JavaScript -->
    <script src="<?php echo $base_path; ?>js/script.js"></script>
</body>
</html>