<?php

namespace Hadzicni\ExpenseTracker;

use PDO;
use PDOException;

class DB {
    private static ?PDO $pdo = null;

    public static function connect(): PDO {
        if (self::$pdo === null) {
            $dbPath = $_ENV['DB_PATH'] ?? (__DIR__ . '/../data/database.sqlite');
            try {
                self::$pdo = new PDO('sqlite:' . $dbPath);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function migrate(): void {
        $sql = "
            CREATE TABLE IF NOT EXISTS transactions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                amount REAL NOT NULL,
                category TEXT NOT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $pdo = self::connect();
        $pdo->exec($sql);
    }
}
