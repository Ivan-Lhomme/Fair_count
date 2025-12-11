<?php
class UserManager extends AbstractManager{
    public function findById(int $id) : User {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return new User($result["nickname"], $result["email"], $result["password"], $result["id"]);
    }

    public function findByEmail(string $email) : ? User {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User($result["nickname"], $result["email"], $result["password"], $result["id"]);
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
            $arrayUsers[] = new User($result["nickname"], $result["email"], $result["password"], $result["id"]);
        }

        return $arrayUsers;
    }

    public function findAll() : array {
        $query = $this->db->prepare("SELECT * FROM users");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayUsers = [];

        foreach ($results as $result) {
            $arrayUsers[] = new User($result["nickname"], $result["email"], $result["password"], $result["id"]);
        }

        return $arrayUsers;
    }
}