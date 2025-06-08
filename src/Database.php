<?php
class Database {
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo) {
            return self::$pdo;
        }

        $driver = getenv('DB_DRIVER') ?: 'sqlite';

        if ($driver === 'sqlite') {
            $dbFile   = __DIR__ . '/../storage/database.sqlite';
            $needInit = !file_exists($dbFile) || filesize($dbFile) === 0;

            self::$pdo = new PDO('sqlite:' . $dbFile);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($needInit) {
                self::createSqliteSchema(self::$pdo);
            }
        } else {
            $cfg = require __DIR__.'/../config/config.php';
            $db  = $cfg['db'];
            $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}";
            self::$pdo = new PDO($dsn, $db['user'], $db['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return self::$pdo;
    }

    /** Минимальная схема, совместимая с SQLite */
    private static function createSqliteSchema(PDO $pdo): void {
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id        INTEGER PRIMARY KEY AUTOINCREMENT,
            name      TEXT,
            email     TEXT,
            password  TEXT,
            role      TEXT DEFAULT 'user',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS comments (
            id         INTEGER PRIMARY KEY AUTOINCREMENT,
            post_id    TEXT NOT NULL,
            parent_id  INTEGER,
            user_id    INTEGER,
            guest_name TEXT,
            guest_email TEXT,
            content    TEXT NOT NULL,
            status     TEXT DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME
        );
        CREATE TABLE IF NOT EXISTS votes (
            id         INTEGER PRIMARY KEY AUTOINCREMENT,
            comment_id INTEGER,
            user_ip    TEXT,
            vote       INTEGER,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS reports (
            id         INTEGER PRIMARY KEY AUTOINCREMENT,
            comment_id INTEGER,
            reporter_ip TEXT,
            reason     TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );";
        $pdo->exec($sql);
    }
}
