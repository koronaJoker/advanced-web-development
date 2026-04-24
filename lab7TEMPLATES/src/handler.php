<?php
require_once "functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST["date"] ?? null;
    $amount = $_POST["amount"] ?? null;
    $category = $_POST["category"] ?? null;
    $description = $_POST["description"] ?? null;

    if ($date && $amount && $category && $description) {
        $transactions = getTransactions();

        $transaction = [
            "id" => getNextId($transactions),
            "date" => $date,
            "amount" => $amount,
            "category" => $category,
            "description" => $description
        ];

        $transactions[] = $transaction;
        saveTransactions($transactions);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && ($_GET["action"] ?? "") === "delete") {
    $id = $_GET["id"] ?? null;

    if ($id !== null) {
        $transactions = getTransactions();

        $transactions = array_filter($transactions, function ($transaction) use ($id) {
            return (string)$transaction["id"] !== (string)$id;
        });

        $transactions = array_values($transactions);
        saveTransactions($transactions);
    }
}

header("Location: ../index.php");
exit;