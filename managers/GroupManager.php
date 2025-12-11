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

    public function findByOwnerId(int $ownerId) : array {
        $query = $this->db->prepare("SELECT groups.* FROM groups JOIN users ON groups.owner_id = users.id where groups.owner_id = :ownerId");
        $parameters = [
            "ownerId" => $ownerId
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return [
            "id" => $result["id"],
            "name" => $result["name"],
            "ownerId" => $result["owner_id"]
        ];
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
}