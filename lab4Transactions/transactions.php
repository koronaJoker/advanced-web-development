<?php
declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2020-02-15",
        "amount" => 75.50,
        "description" => "Dinner with friends",
        "merchant" => "Local Restaurant",
    ],
];
/**
 * @param array $transactions
 * @return float
 */
function calculateTotalAmount(array $transactions): float {
    $sum = 0;
    foreach ($transactions as $transaction) {
        $sum += $transaction["amount"];
    }

    return $sum;

}

/**
 *
 * @param string $descriptionPart
 * @return array|null
 */
function findTransactionByDescription(string $descriptionPart): ?array {
    global $transactions;

    foreach ($transactions as $transaction) {
        if (strpos($transaction["description"], $descriptionPart) !== false) {
            return $transaction;
        }
    }

    return null;
}

/**
 * @param int $id
 * @return array|null
 */
function findTransactionById(int $id): ?array {
    global $transactions;

    $result = array_filter($transactions, function ($transaction) use ($id) {
        return $transaction["id"] === $id;
    });

    return $result ? array_values($result)[0] : null;
}

/**
 * @param string $date
 * @return array[]
 */
function daysSinceTransaction (string $date) {
    global $transactions;
    $todayDate = strtotime($date);
    foreach ($transactions as &$transaction) {
        $transactionDate = strtotime($transaction["date"]);
        $transaction["daysSinceTransaction"] = floor(($todayDate - $transactionDate) / 86400);
    }
    return $transactions;
}


/**
 * @param int $id
 * @param string $date
 * @param float $amount
 * @param string $description
 * @param string $merchant
 * @return void
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;

    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            echo "Ошибка: Транзакция с ID $id уже существует.<br>";
            return;
        }
    }
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant
    ];
}

addTransaction(3, "2022-11-22", 300,"blalblabla", "Corona");
addTransaction(4, "2011-9-22", 800,"blalblabla", "Corona");
$transactions = daysSinceTransaction("2026-03-05");

/**
 * @param array $transactions
 * @return void
 * @description print Table of transactions automatically
 */
function renderTable(array $transactions) {
    echo "<table>";
    echo "<thead><tr>";
    foreach (array_keys($transactions[0]) as $key) {
        echo "<th>$key</th>";
    }
    echo "</tr></thead><tbody>";

    foreach ($transactions as $transaction) {
        echo "<tr>";
        foreach ($transaction as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }

    echo "</tbody></table><br>";
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lab4</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


<table>
<thead>
    <tr>
        <?php
        foreach (array_keys($transactions[0]) as $key) {
            echo "<th>$key</th>";
        }
        ?>
    </tr>
</thead>

<tbody>
<?php
foreach ($transactions as $transaction) {
    echo "<tr>";

    foreach ($transaction as $value) {
        echo "<td>$value</td>";
    }

    echo "</tr>";
}
?>
</tbody>
</table>

<br><hr><br>

<div class="container">

<h2>Результаты функций для $transcations:</h2>
    
    <ol>
        <li>CalculateTotalAmount(): <?= calculateTotalAmount($transactions) ?></li>
        <li>FindTransactionByDescription("Payment for groceries"):
            <?php
            echo "<pre>";
            var_dump(findTransactionByDescription("Payment for groceries"));
            echo "</pre>";
            ?>
        </li>
        <li>FindTransactionByDescription("brbrbrbrbr"):
            <?php
            echo "<pre>";
            var_dump(findTransactionByDescription("brbrbrbrbr"));
            echo "</pre>";
            ?>
        </li>
        <li>FindTransactionById(1):
            <?php
            echo "<pre>";
            var_dump(findTransactionById(1));
            echo "</pre>";
            ?>

        </li>

        <li>FindTransactionById(-1):
            <?php
            echo "<pre>";
            var_dump(findTransactionById(-1));
            echo "</pre>";
            ?>

        </li>

        <li>
            addTransaction(3, "2022-11-22", 300,"blalblabla", "Corona");
            <?php
            echo "<pre>";
            var_dump(findTransactionById(3));
            echo "</pre>";
            ?>
        </li>

        <li>
            addTransaction(3, "2022-11-22", 300,"blalblabla", "Corona");
            <?php
            echo "<pre>";
            var_dump(findTransactionById(3));
            echo "</pre>";
            ?>
        </li>

        <li>
            addTransaction(4, "2011-9-22", 800,"blalblabla", "Corona");
            <?php
            echo "<pre>";
            var_dump(findTransactionById(4));
            echo "</pre>";
            ?>
        </li>
    </ol>
</div>


<h2>Сортировка по дате:</h2>
<?php
// Сортировка по дате
usort($transactions, function($a, $b) {
    return strtotime($a['date']) <=> strtotime($b['date']);
});

renderTable($transactions);
?>

<h2>Сортировка по суммам по убыванию:</h2>
<?php
echo "<pre>";
usort($transactions, function($a, $b) {
    return $b['amount'] <=> $a['amount']; // обратный порядок
});

renderTable($transactions);
?>

</body>
</html>