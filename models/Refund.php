<?php
class Refund{
    public function __construct(private int $amount, private int $ownerId, private int $groupId, private ?int $id = null) {}

    public function getAmount() {
        return $this->amount;
    }
    public function setAmount(int $amount) {
        $this->amount = $amount;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }
    public function setOwnerId(int $ownerId) {
        $this->ownerId = $ownerId;
    }

    public function getGroupId() {
        return $this->groupId;
    }
    public function setGroupId(int $groupId) {
        $this->groupId = $groupId;
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
            "amount" => $this->amount,
            "ownerId" => $this->ownerId,
            "groupId" => $this->groupId
        ];
    }
}