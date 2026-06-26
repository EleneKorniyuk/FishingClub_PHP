<?php
/**
 * Конфигурационный файл сайта
 * Здесь храним все настройки, которые могут меняться
 * или используются в разных местах сайта
*/

// Настройки сайта
const SITE_NAME = 'FishingCLUB';
const BASE_URL = '/fishing_club_examPHP/';
const ITEMS_PER_PAGE = 5; // записей на странице

// Настройки БД
const DB_HOST = 'localhost';
const DB_NAME = 'fishingclub_db';
const DB_USER = 'root';
const DB_PASS = '';

// === Старт сессии (если ещё не запущена) ===
// Позволяет не писать session_start() в каждом файле
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}