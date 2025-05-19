<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Hadzicni\ExpenseTracker\DB;
use Hadzicni\ExpenseTracker\Transactions;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

DB::connect();
DB::migrate();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['amount'], $_POST['category'])) {
    $title = trim($_POST['title']);
    $amount = (float) $_POST['amount'];
    $category = trim($_POST['category']);
    if ($title !== '' && $amount > 0 && $category !== '') {
        Transactions::create($title, $amount, $category);
        $message = '✅ Transaction added successfully.';
    } else {
        $message = '❌ Please fill in all fields correctly.';
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    Transactions::delete((int)$_GET['delete']);
    $message = '❌ Transaction deleted.';
}

$transactions = Transactions::all();
$totalAmount = 0;
foreach ($transactions as $t) {
    $totalAmount += (float) $t['amount'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Tracker</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 540px;
            margin: 40px auto;
            background: #fff;
            border-radius: 9px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            padding: 2.5rem;
        }
        h1 {
            font-weight: 600;
            color: #29394d;
            text-align: center;
            margin-top: 0;
        }
        .message {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 6px;
            background: #f0f4ff;
            color: #0a315d;
            border-left: 4px solid #6aa0ff;
        }
        .total {
            font-size: 1.18rem;
            margin-bottom: 1.6rem;
            font-weight: 600;
            color: #234bb1;
            text-align: right;
            letter-spacing: 0.5px;
        }
        form {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
            justify-content: space-between;
        }
        form input, form select, form button {
            font-size: 1rem;
            padding: 0.5rem;
            border: 1px solid #bfcde0;
            border-radius: 5px;
        }
        form input, form select {
            flex: 1 1 110px;
        }
        form button {
            background: #3067ff;
            color: #fff;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        form button:hover {
            background: #224bcc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #f8fafc;
        }
        th, td {
            padding: 0.9rem 0.5rem;
            text-align: left;
        }
        th {
            background: #e4edfa;
            font-weight: 600;
        }
        tr:not(:last-child) td {
            border-bottom: 1px solid #e0e7ef;
        }
        .amount {
            font-weight: 600;
        }
        .delete-link {
            color: #f44336;
            text-decoration: none;
            font-weight: 600;
        }
        .delete-link:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .container {
                padding: 1.2rem;
            }
            form {
                flex-direction: column;
                gap: 0.5rem;
            }
            .total {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Expense Tracker</h1>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input name="title" type="text" placeholder="Title" required>
            <input name="amount" type="number" min="0.01" step="0.01" placeholder="Amount (CHF)" required>
            <input name="category" type="text" placeholder="Category" required>
            <button type="submit">Add</button>
        </form>
        <div class="total">
            Total: <?= number_format($totalAmount, 2) ?> CHF
        </div>
        <table>
            <tr>
                <th>Title</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Date</th>
                <th></th>
            </tr>
            <?php if (empty($transactions)): ?>
                <tr><td colspan="5" style="text-align:center; color:#666;">No transactions found.</td></tr>
            <?php else: ?>
                <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['title']) ?></td>
                        <td class="amount"><?= number_format($t['amount'], 2) ?> CHF</td>
                        <td><?= htmlspecialchars($t['category']) ?></td>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($t['created_at']))) ?></td>
                        <td>
                            <a class="delete-link" href="?delete=<?= $t['id'] ?>" onclick="return confirm('Delete this transaction?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
