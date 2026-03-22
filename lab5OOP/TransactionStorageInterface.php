<?php

interface TransactionStorageInterface
{
public function addTransaction(Transaction $transaction): void;
public function removeTransactionById(int $id): void;
public function getAllTransactions(): array;
public function findById(int $id): ?Transaction;
}