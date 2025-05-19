<?php

namespace Hadzicni\ExpenseTracker;

use PDO;

class Transactions
{
    public static function create(string $title, float $amount, string $category): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("INSERT INTO transactions (title, amount, category) VALUES (:title, :amount, :category)");
        $stmt->execute([
            ':title' => $title,
            ':amount' => $amount,
            ':category' => $category
        ]);
    }

    public static function all(): array
    {
        $pdo = DB::connect();
        $stmt = $pdo->query("SELECT * FROM transactions ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
        return $transaction ?: null;
    }

    public static function delete(int $id): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
