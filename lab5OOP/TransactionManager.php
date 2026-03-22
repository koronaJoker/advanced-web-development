<?php

class TransactionManager
{
    /**
     * @param TransactionStorageInterface $repository
     */
    public function __construct(private TransactionStorageInterface $repository) {
    }

    /**
     * @return float
     */
    public function calculateTotalAmount(): float {
        $sum = 0;
        foreach($this->repository->getAllTransactions() as $transaction) {
            $sum += $transaction->getAmount();
        }
        return $sum;
    }

    /**
     * @param Datetime $startDate
     * @param DateTime $endDate
     * @return float
     */
    public function calculateTotalAmountByDateRange(Datetime $startDate, DateTime $endDate): float {
        $sum = 0;
        foreach($this->repository->getAllTransactions() as $transaction) {
            if($transaction->getDate() >= $startDate && $transaction->getDate() <= $endDate) {
                $sum += $transaction->getAmount();
            }
        }
        return $sum;
    }

    /**
     * @param string $merchant
     * @return int
     */

    public function countTransactionsByMerchant(string $merchant): int {
        $count = 0;
        foreach($this->repository->getAllTransactions() as $transaction) {
            if($transaction->getMerchant() === $merchant) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * @return array
     */
    public function sortTransactionsByDate(): array {
            $new_arr = $this->repository->getAllTransactions();
            usort($new_arr, fn($a, $b) => $a->getDate() <=> $b->getDate());
            return $new_arr;
        }

    /**
     * @return array
     */
    public function sortTransactionsByAmountDesc() : array {
        $new_arr = $this->repository->getAllTransactions();
        usort($new_arr, fn($a, $b) =>
            $b->getAmount() <=> $a->getAmount());
        return $new_arr;
    }
}