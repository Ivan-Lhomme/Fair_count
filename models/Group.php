<?php
class Group{
    public function __construct(private string $name, private string $ownerName, private array $users, private array $expenses, private array $refunds, private ?int $id = null) {}

    public function getName() {
        return $this->name;
    }
    public function setName(string $name) {
        $this->name = $name;
    }

    public function getOwnerName() {
        return $this->ownerName;
    }
    public function setOwnerName(string $ownerName) {
        $this->ownerName = $ownerName;
    }

    public function getUsers() {
        return $this->users;
    }
    public function setUsers(array $users) {
        $this->users = $users;
    }

    public function getExpenses() {
        return $this->expenses;
    }
    public function setExpenses(array $expenses) {
        $this->expenses = $expenses;
    }

    public function getRefunds() {
        return $this->refunds;
    }
    public function setRefunds(array $refunds) {
        $this->refunds = $refunds;
    }

    public function getId() {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = $id;
    }
}