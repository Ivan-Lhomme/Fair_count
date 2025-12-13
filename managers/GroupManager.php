<?php
class GroupManager extends AbstractManager{
    public function findOne(int $id) : array {
        $query = $this->db->prepare("SELECT * FROM groups where id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return [
            "id" => $result["id"],
            "name" => $result["name"],
            "ownerId" => $result["owner_id"]
        ];
    }

    public function findLast() : array {
        $query = $this->db->prepare("SELECT * FROM groups GROUP BY id DESC");
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return [
            "id" => $result["id"],
            "name" => $result["name"],
            "ownerId" => $result["owner_id"]
        ];
    }

    public function findByOwnerId(int $ownerId) : array {
        $query = $this->db->prepare("SELECT groups.* FROM groups JOIN users ON groups.owner_id = users.id where groups.owner_id = :ownerId");
        $parameters = [
            "ownerId" => $ownerId
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayGroups = [];

        foreach ($results as $result) {
            $arrayGroups[] = [
                "id" => $result["id"],
                "name" => $result["name"]
            ];
        }

        return $arrayGroups;
    }

    public function findByOwnerIdLimited(int $ownerId, ?int $limit = null) : ? array {
        $query = $this->db->prepare("SELECT groups.* FROM groups JOIN users ON groups.owner_id = users.id where groups.owner_id = :ownerId LIMIT $limit");
            $parameters = [
                "ownerId" => $ownerId
            ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayGroups = [];

        foreach ($results as $result) {
            $arrayGroups[] = [
                "id" => $result["id"],
                "name" => $result["name"]
            ];
        }

        return $arrayGroups;
    }

    public function findByContainUserId(int $id) : ? array {
        $query = $this->db->prepare("SELECT groups.id, groups.name, users.nickname FROM group_users JOIN groups ON group_users.group_id = groups.id JOIN users ON groups.owner_id = users.id WHERE user_id = :id AND groups.owner_id != :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayGroups = [];

        foreach ($results as $result) {
            $arrayGroups[] = [
                "id" => $result["id"],
                "name" => $result["name"],
                "owner" => $result["nickname"]
            ];
        }

        return $arrayGroups;
    }

    public function findAll() : array {
        $query = $this->db->prepare("SELECT * FROM groups");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayGroups = [];

        foreach ($results as $result) {
            $arrayGroups[] = [
                "id" => $result["id"],
                "name" => $result["name"],
                "ownerId" => $result["owner_id"]
            ];
        }

        return $arrayGroups;
    }

    public function inGroup(int $groupId, int $userId) : bool {
        $query = $this->db->prepare("SELECT * FROM group_users WHERE group_id = :groupId");
        $parameters = [
            "groupId" => $groupId
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            if ($userId === $result["user_id"]) {
                return true;
            }
        }

        return false;
    }

    public function create(array $group) : void {
        $query = $this->db->prepare("INSERT INTO groups (name, owner_id) VALUES (:name, :ownerId)");
        $parameters = [
            "name" => $group["name"],
            "ownerId" => $group["ownerId"]
        ];
        $query->execute($parameters);
    }

    public function update(array $group) : void {
        $query = $this->db->prepare("UPDATE groups SET name = :name, ownerId = :ownerId WHERE id = :id");
        $parameters = [
            "id" => $group["id"],
            "name" => $group["name"],
            "ownerId" => $group["ownerId"],
        ];
        $query->execute($parameters);
    }

    public function delete(int $id) : void {
        $query = $this->db->prepare("DELETE FROM groups WHERE id = :id");
        $parameters = [
            "id" => $id,
        ];
        $query->execute($parameters);
    }
}