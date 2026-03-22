<?php
declare(strict_types=1);

/**
 * Transaction
 * {int $id, DateTime $date, float $amount, string description,string $merchant}
 */
class Transaction
{
private int $id;
private DateTime $date;
private float $amount;
private string $description;

private string $merchant;

    /**
     * @param int $id
     * @param DateTime $date
     * @param float $amount
     * @param string $description
     * @param string $merchant
     */
public function __construct(int $id, DateTime $date, float $amount, string $description, string $merchant) {
    $this->id = $id;
    $this->date = $date;
    $this->amount = $amount;
    $this->description = $description;
    $this->merchant = $merchant;
}

    /**
     * @return int
     */
public function getId(): int {
    return $this->id;
}

    /**
     * @return DateTime
     */
public function getDate(): DateTime {
    return $this->date;
}

    /**
     * @return float
     */
public function getAmount(): float {
    return $this->amount;
}

    /**
     * @return string
     */
public function getDescription(): string {
    return $this->description;
}

    /**
     * @return string
     */
public function getMerchant(): string {
    return $this->merchant;
}

    /**
     * @return int
     */
public function getDaysSinceTransaction(): int {
    $now = new DateTime();
    return $now->diff($this->date)->days;
}

}