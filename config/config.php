
<?php
/**
 * Global configuration.
 * TODO: replace placeholder values marked with <<<CHANGE-ME>>> before running in production!
 */
return [
    'db' => [
        'host' => 'localhost',
        'name' => 'comments',        // <<<CHANGE-ME>>>
        'user' => 'root',            // <<<CHANGE-ME>>>
        'pass' => '',                // <<<CHANGE-ME>>>
        'charset' => 'utf8mb4'
    ],
    'security' => [
        // Obtain keys at https://www.google.com/recaptcha/admin
        'recaptcha_site_key'   => '<<<CHANGE-ME>>>',
        'recaptcha_secret_key' => '<<<CHANGE-ME>>>'
    ],
    'moderation' => [
        'require_approval'  => true,
        'auto_hide_reports' => 3   // hide comment after 3 unique reports
    ],
    'admin' => [
        // Hash generated via password_hash('yourStrongPassword', PASSWORD_BCRYPT)
        'password_hash' => '<<<CHANGE-ME>>>'
    ],
    'site' => [
        'default_theme' => 'light'  // 'light' | 'dark'
    ]
];
