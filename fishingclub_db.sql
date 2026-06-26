-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час генерацыі: 12 Сак 2026, 13:56
-- Версія сервера: 8.0.30
-- Вэрсія PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даных: `fishingclub_db`
--

-- --------------------------------------------------------

--
-- Структура табліцы `assets`
--

CREATE TABLE `assets` (
  `id` int NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_type` enum('logo','gif','icon','background','favicon') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` int NOT NULL,
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `assets`
--

INSERT INTO `assets` (`id`, `file_path`, `asset_type`, `description`, `section_id`, `is_active`, `sort_order`) VALUES
(1, '../img/logo.png', 'logo', 'Логотип FishingCLUB', 1, 1, 1),
(2, '../img/icon_fishing.png', 'favicon', 'Иконка сайта', 1, 1, 2),
(3, '../img/semja_gif.gif', 'gif', 'Анимированная гифка семьи на рыбалке', 1, 1, 3),
(4, '../img/geo_metka.png', 'icon', 'Иконка геометки', 4, 1, 4),
(5, '../img/tel.png', 'icon', 'Иконка телефона', 4, 1, 5),
(6, '../img/mail.png', 'icon', 'Иконка email', 4, 1, 6),
(7, '../img/insta.png', 'icon', 'Иконка Instagram', 4, 1, 7),
(8, '../img/vk.png', 'icon', 'Иконка ВКонтакте', 4, 1, 8),
(9, '../img/tiktok.png', 'icon', 'Иконка TikTok', 4, 1, 9),
(10, '../img/telega.png', 'icon', 'Иконка Telegram', 4, 1, 10),
(11, '../img/kruchok_1.png', 'icon', 'Декоративный крючок 1', 2, 1, 20),
(12, '../img/kruchok_2.png', 'icon', 'Декоративный крючок 2', 2, 1, 21),
(13, '../img/kruchok_strelka_left.png', 'icon', 'Крючок-стрелка карусели влево', 3, 1, 22),
(14, '../img/kruchok_strelka_right.png', 'icon', 'Крючок-стрелка карусели вправо', 3, 1, 23),
(15, '../img/rubka_1.png', 'icon', 'Декоративная рыбка 1', 1, 1, 24),
(16, '../img/rubka_2.png', 'icon', 'Декоративная рыбка 2', 1, 1, 25);

-- --------------------------------------------------------

--
-- Структура табліцы `comfort_services`
--

CREATE TABLE `comfort_services` (
  `id` int NOT NULL,
  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price_info` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` int NOT NULL,
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `comfort_services`
--

INSERT INTO `comfort_services` (`id`, `service_name`, `description`, `price_info`, `section_id`, `is_active`, `sort_order`) VALUES
(1, 'Домики и беседки', 'Комфортабельные домики и беседки для отдыха', 'Посуточная аренда', 2, 1, 1),
(2, 'Баня на дровах', 'Традиционная русская баня на дровах', 'Аренда на 2-3 часа', 2, 1, 2),
(3, 'Детские площадки', 'Детские площадки с батутом и горками', 'Бесплатно для гостей', 2, 1, 3);

-- --------------------------------------------------------

--
-- Структура табліцы `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `type` enum('phone','email','social','address','timetable','map') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_id` int DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `contacts`
--

INSERT INTO `contacts` (`id`, `type`, `value`, `label`, `asset_id`, `sort_order`, `is_active`) VALUES
(1, 'address', 'д. Вишневка Папернянский с/т', 'Адрес', 4, 1, 1),
(2, 'phone', '+375256308178', 'Основной телефон', 5, 2, 1),
(3, 'phone', '+375255012398', 'Дополнительный телефон', 5, 3, 1),
(4, 'email', 'lena.stahvskaja@gmail.com', 'Email', 6, 4, 1),
(5, 'timetable', 'вторник - пятница 06:00 - 22:00', 'Рабочие дни', NULL, 5, 1),
(6, 'timetable', 'суббота - воскресенье 06:00 - 24:00', 'Выходные дни', NULL, 6, 1),
(7, 'social', 'https://instagram.com', 'Instagram', 7, 7, 1),
(8, 'social', 'https://vk.com', 'ВКонтакте', 8, 8, 1),
(9, 'social', 'https://tiktok.com', 'TikTok', 9, 9, 1),
(10, 'social', 'https://telegram.org', 'Telegram', 10, 10, 1),
(11, 'map', 'https://yandex.ru/map-widget/v1/?ll=27.561481%2C53.902496&z=12', 'Карта проезда', 4, 11, 1);

-- --------------------------------------------------------

--
-- Структура табліцы `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price_info` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timetable_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` int NOT NULL,
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `events`
--

INSERT INTO `events` (`id`, `event_name`, `description`, `price_info`, `timetable_info`, `section_id`, `is_active`, `sort_order`) VALUES
(1, 'Любовь к рыбалке дарит подарки', 'Соревнования по рыбной ловле с ценными и памятными подарками в различных номинациях', 'Уточняйте у администратора', 'По предварительной записи', 3, 1, 1),
(2, 'Интерактивная обучающая рыбалка', 'Обучающая рыбалка для наших маленьких гостей', 'Бесплатно', 'Каждую субботу с 12:00 до 15:00', 3, 1, 2),
(3, 'Спортивный мастер-класс по ловле форели', 'Профессиональный мастер-класс по ловле форели', 'Уточняйте у администратора', 'По предварительной записи', 3, 1, 3);

-- --------------------------------------------------------

--
-- Структура табліцы `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_id` int NOT NULL,
  `submission_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('new','in_progress','answered','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `phone`, `message`, `section_id`, `submission_date`, `status`) VALUES
(1, 'Иван Петров', 'ivan.petrov@mail.ru', '+375291234567', 'Здравствуйте! Хочу забронировать беседку на выходные для компании друзей. Подскажите, есть ли свободные на 15-16 ноября?', 2, '2025-11-10 10:30:00', 'answered'),
(2, 'Екатерина Новикова', 'katya.novikova@tut.by', '+375255556677', 'Большое Вам спасибо за замечательное место отдыха! Мы великолепно провели время на Вашем пруду! Особенно понравилась баня и детская площадка. Обязательно вернемся!', 1, '2025-11-12 18:20:00', 'closed'),
(3, 'Сергей Рыбаков', 'sergey.rybakov@yandex.ru', '+375441117788', 'Как опытный рыбак оцениваю на 10/10! Пруд действительно зарыблен, прикормка качественная. Поймал форель и двух карпов. Персонал подсказал лучшие места для ловли. Рекомендую всем рыбакам!', 2, '2025-11-17 16:20:00', 'closed'),
(4, 'Дмитрий Волков', 'dima.volkov@mail.ru', '+375298889900', 'Интересует мастер-класс по ловле форели. Когда ближайшее мероприятие и сколько стоит участие?', 3, '2025-11-23 11:10:00', 'answered'),
(5, 'Сергей Баранов', 'sergey.baranov@yandex.ru', '+375441234567', 'Вопрос по времени работы: в понедельник вы работаете? Хотим приехать на целый день.', 4, '2025-11-24 08:30:00', 'answered'),
(6, 'Александр Белов', 'alex.belov@mail.ru', '+375291122334', 'Интересует корпоративный выезд для сотрудников на 20 человек. Возможно ли организовать тимбилдинг с элементами рыбалки и обедом на природе?', 2, '2025-11-25 09:15:00', 'new'),
(7, 'Павел Морозов', 'pavel.morozov@tut.by', '+375334445566', 'Ищу подарок другу-рыбаку. Есть ли у вас подарочные сертификаты или специальные предложения?', 1, '2025-11-27 10:15:00', 'in_progress'),
(8, 'Ольга Шевцова', 'olga.shevtsov@mail.ru', '+375299988776', 'Планируем приехать с собакой (лабрадор). Разрешено ли посещение с домашними животными? Есть ли какие-то ограничения?', 4, '2025-11-27 11:25:00', 'in_progress'),
(9, 'Алексей Козлов', 'alex.kozlov@gmail.com', '+375441112233', 'Планируем приехать семьей с детьми в субботу. Уточните, пожалуйста, про обучающую рыбалку для детей - нужно ли записываться заранее?', 3, '2025-11-30 09:45:00', 'new'),
(10, 'Наталья Семенова', 'natali.semenova@gmail.com', '+375256667788', 'Были вчера - остались в полном восторге! Спасибо за отличный отдых! Фото выложили в инстаграм с отметкой комплекса.', 1, '2025-11-30 19:05:00', 'new'),
(11, 'Николай Юрьевич Корниюк', 'nikolaykornijuk@gmail.com', '80255022398', 'Люблю ваш клуб! Лучшее место для рыбалки и отдыха.', 1, '2026-02-20 16:58:56', 'new'),
(12, 'Николай', 'nikolaykornijuk@gmail.com', '80255022398', 'Хочу поблагодарить Вашу команду! Случайно отправил форму бронирования дважды, ребята связались для уточнения буквально в течении минуты и всё решили. Спасибо за оперативность!', 1, '2026-03-11 23:13:44', 'new');

-- --------------------------------------------------------

--
-- Структура табліцы `fishing_services`
--

CREATE TABLE `fishing_services` (
  `id` int NOT NULL,
  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `price_info` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` int NOT NULL,
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `fishing_services`
--

INSERT INTO `fishing_services` (`id`, `service_name`, `description`, `details`, `price_info`, `section_id`, `is_active`, `sort_order`) VALUES
(1, 'Рыбалка', 'Классическая и спортивная рыбалка', 'Чистый пруд, зарыбленный: карпом, форелью, амуром, толстолобиком, щукой и осетром. Ловля рыбы разрешена удочками всех видов и спиннингом.', 'Уточняйте у администратора', 2, 1, 1),
(2, 'Прокат снастей', 'Прокат рыболовных снастей', 'Лучше взять побольше друзей и поменьше вещей, всё, что нужно для рыбалки у нас есть', 'Удочка, Фидер, Спиннинг. Подсачек, садок. Наживка, прикормки и многое другое.', 2, 1, 2),
(3, 'Улов готовь', 'Приготовление улова', 'Совместное приготовление улова на открытой кухне надолго останется в памяти у всех.', 'Дополнительная услуга, уточняйте у администратора', 2, 1, 3);

-- --------------------------------------------------------

--
-- Структура табліцы `images`
--

CREATE TABLE `images` (
  `id` int NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_type` enum('fishing_service','comfort_service','event','gallery') COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` int DEFAULT NULL,
  `section_id` int NOT NULL,
  `sort_order` int DEFAULT '0',
  `upload_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `images`
--

INSERT INTO `images` (`id`, `file_path`, `alt_text`, `entity_type`, `entity_id`, `section_id`, `sort_order`, `upload_date`) VALUES
(1, '../img/foto_rubalka.jpg', 'рыбалка', 'fishing_service', 1, 2, 1, '2025-11-27 12:12:12'),
(2, '../img/foto_prokat.jpg', 'снасти_прокат', 'fishing_service', 2, 2, 2, '2025-11-27 12:12:12'),
(3, '../img/ylov_gotov.jpg', 'улов_на_мангале', 'fishing_service', 3, 2, 3, '2025-11-27 12:12:12'),
(4, '../img/domiki_besedki.jpg', 'домики_и_беседки', 'comfort_service', 1, 2, 1, '2025-11-27 12:13:02'),
(5, '../img/banya.jpg', 'баня', 'comfort_service', 2, 2, 2, '2025-11-27 12:13:02'),
(6, '../img/detskaya_poschadka.jpg', 'детская_площадка', 'comfort_service', 3, 2, 3, '2025-11-27 12:13:02'),
(7, '../img/fishing_presents.jpg', 'рыбалка_подарки', 'event', 1, 3, 1, '2025-11-27 12:18:58'),
(8, '../img/fishing_lessons.jpg', 'обучающая_рыбалка', 'event', 2, 3, 2, '2025-11-27 12:18:58'),
(9, '../img/master_classes.jpg', 'мастер_класс', 'event', 3, 3, 3, '2025-11-27 12:18:58'),
(10, '../img/rubaki_1.jpg', 'рыбак_1', 'gallery', NULL, 3, 1, '2025-11-27 12:22:21'),
(11, '../img/rubaki_2.jpg', 'рыбак_2', 'gallery', NULL, 3, 2, '2025-11-27 12:22:21'),
(12, '../img/rubaki_3.jpg', 'рыбак_3', 'gallery', NULL, 3, 3, '2025-11-27 12:22:21'),
(13, '../img/rubaki_4.jpg', 'рыбак_4', 'gallery', NULL, 3, 4, '2025-11-27 12:22:21'),
(14, '../img/rubaki_5.jpg', 'рыбак_5', 'gallery', NULL, 3, 5, '2025-11-27 12:22:21'),
(15, '../img/rubaki_6.jpg', 'рыбак_6', 'gallery', NULL, 3, 6, '2025-11-27 12:22:21'),
(16, '../img/rubaki_7.jpg', 'рыбак_7', 'gallery', NULL, 3, 7, '2025-11-27 12:22:21'),
(17, '../img/rubaki_8.jpg', 'рыбак_8', 'gallery', NULL, 3, 8, '2025-11-27 12:22:21'),
(18, '../img/rubaki_9.jpg', 'рыбак_9', 'gallery', NULL, 3, 9, '2025-11-27 12:22:21'),
(19, '../img/rubaki_10.jpg', 'рыбак_10', 'gallery', NULL, 3, 10, '2025-11-27 12:22:21'),
(20, '../img/rubaki_11.jpg', 'рыбак_11', 'gallery', NULL, 3, 11, '2025-11-27 12:22:21'),
(21, '../img/rubaki_12.jpg', 'рыбак_12', 'gallery', NULL, 3, 12, '2025-11-27 12:22:21'),
(22, '../img/rubaki_13.jpg', 'рыбак_13', 'gallery', NULL, 3, 13, '2025-11-27 12:22:21'),
(23, '../img/rubaki_14.jpg', 'рыбак_14', 'gallery', NULL, 3, 14, '2025-11-27 12:22:21'),
(24, '../img/rubaki_15.jpg', 'рыбак_15', 'gallery', NULL, 3, 15, '2025-11-27 12:22:21'),
(25, '../img/rubaki_16.jpg', 'рыбак_16', 'gallery', NULL, 3, 16, '2025-11-27 12:22:21'),
(26, '../img/rubaki_17.jpg', 'рыбак_17', 'gallery', NULL, 3, 17, '2025-11-27 12:22:21'),
(27, '../img/rubaki_18.jpg', 'рыбак_18', 'gallery', NULL, 3, 18, '2025-11-27 12:22:21'),
(28, '../img/rubaki_19.jpg', 'рыбак_19', 'gallery', NULL, 3, 19, '2025-11-27 12:22:21'),
(29, '../img/rubaki_20.jpg', 'рыбак_20', 'gallery', NULL, 3, 20, '2025-11-27 12:22:21'),
(30, '../img/rubaki_21.jpg', 'рыбак_21', 'gallery', NULL, 3, 21, '2025-11-27 12:22:21');

-- --------------------------------------------------------

--
-- Структура табліцы `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reservation_type` enum('fishing_service','comfort_service','event') COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` int NOT NULL,
  `section_id` int NOT NULL,
  `desired_date` date NOT NULL,
  `special_requests` text COLLATE utf8mb4_unicode_ci,
  `status` enum('new','confirmed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `reservations`
--

INSERT INTO `reservations` (`id`, `customer_name`, `customer_phone`, `customer_email`, `reservation_type`, `entity_id`, `section_id`, `desired_date`, `special_requests`, `status`, `created_at`) VALUES
(1, 'Андрей Смирнов', '+375291234568', 'andrey.smirnov@mail.ru', 'comfort_service', 1, 2, '2025-11-29', 'Нужна беседка с мангалом на 8 человек. Предоплату готовы внести в любое время.', 'confirmed', '2025-11-15 11:20:00'),
(2, 'Виктор Орлов', '+375441112234', 'viktor.orlov@gmail.com', 'event', 2, 3, '2025-11-29', 'Хотим записать двух детей (6 и 8 лет) на обучающую рыбалку. Нужна помощь инструктора.', 'confirmed', '2025-11-20 10:30:00'),
(3, 'Ирина Соколова', '+375336667789', 'irina.sokolova@gmail.com', 'comfort_service', 1, 2, '2025-12-06', 'День рождения - 15 человек. Нужна большая беседка, мангал, подготовка места.', 'confirmed', '2025-11-20 17:20:00'),
(4, 'Артем Попов', '+375441234568', 'artem.popov@yandex.ru', 'fishing_service', 1, 2, '2025-11-27', 'Рыбалка на целый день или на сутки. Свои снасти. Интересует карп и амур.', 'confirmed', '2025-11-21 09:10:00'),
(5, 'Денис Федоров', '+375293334455', 'denis.fedorov@mail.ru', 'comfort_service', 2, 2, '2025-12-05', 'Баня на 2 часа с 20:00. Просьба охладить напитки.', 'cancelled', '2025-11-23 10:45:00'),
(6, 'Роман Григорьев', '+375334445567', 'roman.grig@tut.by', 'fishing_service', 3, 2, '2025-11-28', 'Хотим приготовить улов на вашей кухне. Какие условия?', 'new', '2025-11-23 11:05:00'),
(7, 'Татьяна Романова', '+375337654322', 'tanya.romanova@yandex.by', 'fishing_service', 2, 2, '2025-12-04', 'Требуется прокат 2 спиннингов и набор прикормки. Приедем к 10 утра.', 'new', '2025-11-23 15:45:00'),
(8, 'Максим Лебедев', '+375298889901', 'max.lebedev@mail.ru', 'event', 3, 3, '2025-12-10', 'Интересует участие в мастер-классе по форели. Опыт рыбалки 2 года.', 'new', '2025-11-24 12:25:00'),
(9, 'Юрий Павлов', '+375256667789', 'yurii.pavlov@gmail.com', 'event', 1, 3, '2025-12-12', 'Участие в мероприятии Любовь к рыбалке дарит подарки для компании рыбаков-любителей из 4 человек.', 'new', '2025-11-25 20:15:00'),
(10, 'Алина Медведева', '+375338885566', 'alina.medvedeva@yandex.by', 'fishing_service', 2, 2, '2025-12-04', 'Новички в рыбалке. Хотим порыбачить в Вашем комплексе в дневное время. Нужен прокат снастей и консультация.', 'new', '2025-11-26 14:20:00'),
(11, 'Николай', '80255022398', 'nikolaykornijuk@gmail.com', 'comfort_service', 1, 2, '2026-03-27', 'Хотим приехать с семьей на сутки на рыбалку. По возможности желателен к бронированию домик на берегу, сектор рядом с пирсом. Спасибо!', 'cancelled', '2026-03-11 23:08:49'),
(12, 'Николай', '80255022398', 'nikolaykornijuk@gmail.com', 'comfort_service', 1, 2, '2026-03-27', 'Хотим приехать с семьей на сутки на рыбалку. По возможности желателен к бронированию домик на берегу, сектор рядом с пирсом. Спасибо!', 'new', '2026-03-11 23:09:06');

-- --------------------------------------------------------

--
-- Структура табліцы `site_structure`
--

CREATE TABLE `site_structure` (
  `id` int NOT NULL,
  `page_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `site_structure`
--

INSERT INTO `site_structure` (`id`, `page_name`, `is_active`, `sort_order`) VALUES
(1, 'Главная', 1, 1),
(2, 'Наши услуги', 1, 2),
(3, 'Галерея событий', 1, 3),
(4, 'Контакты', 1, 4);

-- --------------------------------------------------------

--
-- Структура табліцы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп дадзеных табліцы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`) VALUES
(1, 'admin', '$2y$10$tMN4bD/kAzqfyY2ZI7L/FeJLZaEYn3e7JDfSlpNy8SzplwP1kWa5m');

--
-- Індэксы для захаваных табліц
--

--
-- Індэксы табліцы `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_asset_type` (`asset_type`),
  ADD KEY `idx_section` (`section_id`);

--
-- Індэксы табліцы `comfort_services`
--
ALTER TABLE `comfort_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Індэксы табліцы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_active_order` (`is_active`,`sort_order`),
  ADD KEY `idx_asset` (`asset_id`);

--
-- Індэксы табліцы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Індэксы табліцы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_submission_date` (`submission_date`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_date_status` (`submission_date`,`status`),
  ADD KEY `idx_section` (`section_id`);

--
-- Індэксы табліцы `fishing_services`
--
ALTER TABLE `fishing_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `idx_active_order` (`is_active`,`sort_order`);

--
-- Індэксы табліцы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `idx_entity` (`entity_type`,`entity_id`);

--
-- Індэксы табліцы `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status_date` (`status`,`desired_date`),
  ADD KEY `idx_type_entity` (`reservation_type`,`entity_id`),
  ADD KEY `idx_phone` (`customer_phone`(15)),
  ADD KEY `idx_section` (`section_id`),
  ADD KEY `idx_created` (`created_at`);

--
-- Індэксы табліцы `site_structure`
--
ALTER TABLE `site_structure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_active_sort` (`is_active`,`sort_order`);

--
-- Індэксы табліцы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для захаваных табліц
--

--
-- AUTO_INCREMENT для табліцы `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для табліцы `comfort_services`
--
ALTER TABLE `comfort_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для табліцы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для табліцы `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для табліцы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для табліцы `fishing_services`
--
ALTER TABLE `fishing_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для табліцы `images`
--
ALTER TABLE `images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для табліцы `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для табліцы `site_structure`
--
ALTER TABLE `site_structure`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для табліцы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Абмежаваньні для экспартаваных табліц
--

--
-- Абмежаваньні для табліцы `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `fk_assets_section` FOREIGN KEY (`section_id`) REFERENCES `site_structure` (`id`);

--
-- Абмежаваньні для табліцы `comfort_services`
--
ALTER TABLE `comfort_services`
  ADD CONSTRAINT `fk_comfort_section` FOREIGN KEY (`section_id`) REFERENCES `site_structure` (`id`);

--
-- Абмежаваньні для табліцы `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_contacts_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`);

--
-- Абмежаваньні для табліцы `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_section` FOREIGN KEY (`section_id`) REFERENCES `site_structure` (`id`);

--
-- Абмежаваньні для табліцы `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_section` FOREIGN KEY (`section_id`) REFERENCES `site_structure` (`id`);

--
-- Абмежаваньні для табліцы `fishing_services`
--
ALTER TABLE `fishing_services`
  ADD CONSTRAINT `fk_fishing_services_section` FOREIGN KEY (`section_id`) REFERENCES `site_structure` (`id`);

--
-- Абмежаваньні для табліцы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_section` FOREIGN KEY (`section_id`) REFERENCES `site_structure` (`id`);

--
-- Абмежаваньні для табліцы `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_section` FOREIGN KEY (`section_id`) REFERENCES `site_structure` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
