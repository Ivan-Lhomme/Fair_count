<?php
class Expense{
    public function __construct(private string $reason, private int $amount, private int $ownerId, private string $category, private ?int $id = null) {}

    public function getReason() {
        return $this->reason;
    }
    public function setReason(string $reason) {
        $this->reason = $reason;
    }

    public function getAmount() {
        return $this->amount;
    }
    public function setAmount(string $amount) {
        $this->amount = $amount;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }
    public function setOwnerId(string $ownerId) {
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
    public function setId(string $id) {
        $this->id = $id;
    }
}