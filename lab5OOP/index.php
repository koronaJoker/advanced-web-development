<?php
declare(strict_types = 1);
?>
<style>
    body {
        text-align: center;
        font-family: Consolas, sans-serif;
        background: #f5f7fa;
        padding: 20px;
    }

    table {
        text-align: center;
        width: 800px;
        margin: auto;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    th {
        background: #4f46e5;
        color: white;
        padding: 10px;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    tr:hover {
        background: #f1f5f9;
    }
</style>

<?php

spl_autoload_register(function ($class) {
    require_once $class . '.php';
});



$data = [
    [1, "2000-01-15", 12.5, "кофе", "McDonalds"],
    [2, "2019-02-22", 59.9, "донат в игру", "Steam"],
    [3, "2024-07-20", 1200, "зарплата", "Работа"],
    [4, "2023-08-30", 300, "аренда квартиры", "Злая бабка"],
    [5, "2024-09-22", 15.7, "кофе №2", "Cucurigo"],
    [6, "2024-10-04", 220, "продукты", "Базар"],
    [7, "2026-08-25", 999.9, "новый телефон", "nr1"],
    [8, "2024-01-12", 5.99, "подписка", "ChatGpt"],
    [9, "2001-11-27", 50, "вернул долг другу", "AlexeiPustovoi"],
    [10, "2024-12-28", 42, "такси", "TaxiUral"],
];

$transactions = [];

foreach ($data as $item) {
    $transactions[] = new Transaction(
        $item[0],
        new DateTime($item[1]),
        $item[2],
        $item[3],
        $item[4]
    );
}

$tableRenderer = new TransactionTableRenderer();
echo $tableRenderer->render($transactions);

echo '<br><hr><br>';
$transactionRepository = new TransactionRepository($transactions);
$transactionManager = new TransactionManager($transactionRepository);
echo $transactionManager->calculateTotalAmount(). "<br>";
echo $transactionManager->calculateTotalAmountByDateRange(new DateTime("2000-12-01"),new DateTime("2024-12-08"));

echo "<br><hr><br> <h1>SORTED DATA</h1> <br>";
$transactions = $transactionManager->sortTransactionsByDate();
echo $tableRenderer->render($transactions);

echo "<br><hr><br> <h1>SORTED AMOUNT</h1> <br>";
$transactions = $transactionManager->sortTransactionsByAmountDesc();
echo $tableRenderer->render($transactions);
echo "<h1>countTransactionsByMerchant('Работа')</h1> <br>";
echo $transactionManager->countTransactionsByMerchant("Работа");
