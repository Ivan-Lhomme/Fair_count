<?php
class UserManager extends AbstractManager{
    public function findById(int $id) : User {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return new User($result["nickname"], $result["email"], $result["password"], $result["money"], $result["id"]);
    }

    public function findByEmail(string $email) : ? User {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User($result["nickname"], $result["email"], $result["password"], $result["money"], $result["id"]);
        }
        
        return null;
    }

    public function findByGroupId(int $groupId) : array {
        $query = $this->db->prepare("SELECT users.* FROM users JOIN group_users ON users.id = group_users.user_id JOIN groups ON group_users.group_id = groups.id WHERE groups.id = :groupId;");
        $parameters = [
            "groupId" => $groupId
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayUsers = [];

        foreach ($results as $result) {
            $arrayUsers[] = new User($result["nickname"], $result["email"], $result["password"], $result["money"], $result["id"]);
        }

        return $arrayUsers;
    }

    public function findAll() : array {
        $query = $this->db->prepare("SELECT * FROM users");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayUsers = [];

        foreach ($results as $result) {
            $arrayUsers[] = new User($result["nickname"], $result["email"], $result["password"], $result["money"], $result["id"]);
        }

        return $arrayUsers;
    }

    public function create(array $user) : void {
        $query = $this->db->prepare("INSERT INTO users (nickname, email, password) VALUES (:nickname, :email, :password)");
        $parameters = [
            "nickname" => $user["nickname"],
            "email" => $user["email"],
            "password" => $user["password"]
        ];
        $query->execute($parameters);
    }

    public function update(array $user) : void {
        $query = $this->db->prepare("UPDATE users SET nickname = :nickname, email = :email, password = :password WHERE id = :id");
        $parameters = [
            "id" => $user["id"],
            "nickName" => $user["nickname"],
            "email" => $user["email"],
            "password" => $user["password"]
        ];
        $query->execute($parameters);
    }

    public function addMoney(int $id, float $money) : void {
        $actualMoney = $this->findById($id)->getMoney();

        $query = $this->db->prepare("UPDATE users SET money = :money WHERE id = :id");
        $parameters = [
            "id" => $id,
            "money" => $actualMoney + $money
        ];
        $query->execute($parameters);
    }

    public function subMoney(int $id, float $money) : void {
        $actualMoney = $this->findById($id)->getMoney();

        $query = $this->db->prepare("UPDATE users SET money = :money WHERE id = :id");
        $parameters = [
            "id" => $id,
            "money" => $actualMoney - $money
        ];
        $query->execute($parameters);
    }

    public function delete(int $id) : void {
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $parameters = [
            "id" => $id,
        ];
        $query->execute($parameters);
    }
}