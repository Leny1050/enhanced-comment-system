<?php
/**
 * Global configuration.
 * TODO: replace placeholder values marked with <<<CHANGE-ME>>> before running in production!
 */

/* 1. Определяем драйвер БД: sqlite (по умолчанию) или mysql */
$driver = getenv('DB_DRIVER') ?: 'sqlite';            // 'sqlite' | 'mysql'

return [

    /* 2. Передаём выбранный драйвер в приложение */
    'driver' => $driver,

    /* 3. Параметры MySQL (игнорируются, если driver = sqlite) */
    'db' => [
        'host'    => getenv('DB_HOST') ?: 'localhost',
        'name'    => getenv('DB_NAME') ?: 'comments',   // <<<CHANGE-ME>>>
        'user'    => getenv('DB_USER') ?: 'root',       // <<<CHANGE-ME>>>
        'pass'    => getenv('DB_PASS') ?: '',           // <<<CHANGE-ME>>>
        'charset' => 'utf8mb4'
    ],

    /* 4. Защита от спама (reCAPTCHA) */
    'security' => [
        'recaptcha_site_key'   => getenv('RECAPTCHA_SITE_KEY')   ?: '<<<CHANGE-ME>>>',
        'recaptcha_secret_key' => getenv('RECAPTCHA_SECRET_KEY') ?: '<<<CHANGE-ME>>>'
    ],

    /* 5. Настройки модерации */
    'moderation' => [
        'require_approval'  => true,   // премодерация
        'auto_hide_reports' => 3       // скрывать после 3 жалоб
    ],

    /* 6. Доступ администратора */
    'admin' => [
        // bcrypt-хэш от password_hash('demo', PASSWORD_BCRYPT) — замените!
        'password_hash' => getenv('ADMIN_HASH') ?: '<<<CHANGE-ME>>>'
    ],

    /* 7. Внешний вид */
    'site' => [
        'default_theme' => getenv('DEFAULT_THEME') ?: 'light'   // 'light' | 'dark'
    ]
];
