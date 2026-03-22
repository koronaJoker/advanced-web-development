<?php
class TransactionRepository implements TransactionStorageInterface {
    private array $transactions = [];

    /**
     * @param array $transactions
     */
    public function __construct(array $transactions) {
        $this->transactions = $transactions;
    }

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function addTransaction(Transaction $transaction): void {
        $this->transactions[] = $transaction;
    }

    /**
     * @param int $id
     * @return void
     */
    public function removeTransactionById(int $id): void {
        foreach ($this->transactions as $index => $transaction) {
            if ($transaction->getId() === $id) {
                array_splice($this->transactions, $index, 1);
            }
        }
    }

    /**
     * @return array
     */
    public function getAllTransactions() : array {
        return $this->transactions;
    }

    /**
     * @param int $id
     * @return Transaction|null
     */
    public function findById(int $id) : ?Transaction {
        foreach ($this->transactions as $transaction) {
            if ($transaction->getId() === $id) {
                return $transaction;
            }
        }
        return null;
    }

}

