<?php
class Expense{
    public function __construct(private string $reason, private float $amount, private int $ownerId, private string $category, private ?int $id = null) {}

    public function getReason() {
        return $this->reason;
    }
    public function setReason(string $reason) {
        $this->reason = $reason;
    }

    public function getAmount() {
        return $this->amount;
    }
    public function setAmount(float $amount) {
        $this->amount = $amount;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }
    public function setOwnerId(int $ownerId) {
        $this->ownerId = $ownerId;
    }

    public function getCategory() {
        return $this->category;
    }
    public function setCategory(string $category) {
        $this->category = $category;
    }

    public function getId() {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = $id;
    }

    public function toArray() : array {
        return [
            "id" => $this->id,
            "reason" => $this->reason,
            "amount" => $this->amount,
            "ownerId" => $this->ownerId,
            "category" => $this->category
        ];
    }
}