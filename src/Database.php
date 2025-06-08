<?php
class Database {
    private static $pdo = null;
    public static function getConnection() {
        if (self::$pdo) return self::$pdo;

        $driver = getenv('DB_DRIVER') ?: 'sqlite';

        if ($driver === 'sqlite') {
            $path = __DIR__ . '/../storage/database.sqlite';
            $needInit = !file_exists($path) || filesize($path) === 0;
            self::$pdo = new PDO('sqlite:' . $path);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($needInit) {
                self::$pdo->exec(file_get_contents(__DIR__.'/../install.sql'));
            }
        } else {  // MySQL — на будущее
            $cfg = require __DIR__.'/../config/config.php';
            $db = $cfg['db'];
            $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}";
            self::$pdo = new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return self::$pdo;
    }
}
