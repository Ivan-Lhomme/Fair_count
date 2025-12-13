<?php
class User{
    public function __construct(private string $nickName, private string $email, private string $password, private float $money = 0, private ?int $id = null) {}

    public function getNickName() {
        return $this->nickName;
    }
    public function setNickName(string $nickName) {
        $this->nickName = $nickName;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getMoney() {
        return $this->money;
    }
    public function setMoney(float $money) {
        $this->money = $money;
    }

    public function getId() {
        return $this->id;
    }
    public function setId(string $id) {
        $this->id = $id;
    }

    public function toArray() : array {
        return [
            "id" => $this->id,
            "nickName" => $this->nickName,
            "email" => $this->email,
            "password" => $this->password,
            "money" => $this->money
        ];
    }
}