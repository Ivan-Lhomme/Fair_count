<?php
class RefundManager extends AbstractManager{
    public function findById(int $id) : Refund {
        $query = $this->db->prepare("SELECT * FROM refunds WHERE id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return new Refund($result["amount"], $result["owner_id"], $result["group_id"], $result["id"]);
    }

    public function findByGroupId(int $groupId) : array {
        $query = $this->db->prepare("SELECT * FROM refunds WHERE group_id = :groupId");
        $parameters = [
            "groupId" => $groupId
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayRefunds = [];

        foreach ($results as $result) {
            $arrayRefunds[] = new Refund($result["amount"], $result["owner_id"], $result["group_id"], $result["id"]);
        }

        return $arrayRefunds;
    }

    public function findAll() : array {
        $query = $this->db->prepare("SELECT * FROM refunds");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayRefunds = [];

        foreach ($results as $result) {
            $arrayRefunds[] = new Refund($result["amount"], $result["owner_id"], $result["group_id"], $result["id"]);
        }

        return $arrayRefunds;
    }
}