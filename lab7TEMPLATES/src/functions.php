<?php

 function getTransactions() {
    $transactionsFile = __DIR__ . "/../transactions.json";
    if (file_exists($transactionsFile)) {
        $transactionsData = file_get_contents($transactionsFile);
        return json_decode($transactionsData, true) ?? [];
    }
    return [];
}

function saveTransactions($transactions) {
    $transactionsFile = __DIR__ . "/../transactions.json";
    file_put_contents($transactionsFile, json_encode($transactions, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function getNextId($transactions) {
    if (empty($transactions)) {
        return 1;
    }

    $ids = array_column($transactions, 'id');
    return max($ids) + 1;
}


    