<?php
class joinRequestManager extends AbstractManager{
    public function findById(int $id) : joinRequest {
        $query = $this->db->prepare("SELECT * FROM join_requests WHERE id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return new joinRequest($result["sender_id"], $result["receiver_id"], $result["group_id"], $result["id"]);
    }

    public function findAll() : array {
        $query = $this->db->prepare("SELECT * FROM join_requests");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayRequest = [];

        foreach ($results as $result) {
            $arrayRequest[] = new joinRequest($result["sender_id"], $result["receiver_id"], $result["group_id"], $result["id"]);
        }

        return $arrayRequest;
    }

    public function findByGroupId(int $groupId) : array {
        $query = $this->db->prepare("SELECT * FROM join_requests WHERE group_id = :groupId AND status = 'wait'");
        $parameters = [
            "groupId" => $groupId
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayRequest = [];

        foreach ($results as $result) {
            $arrayRequest[] = new joinRequest($result["sender_id"], $result["receiver_id"], $result["group_id"], $result["id"]);
        }

        return $arrayRequest;
    }

    public function findByReceiverId(int $receiverId) : array {
        $query = $this->db->prepare("SELECT * FROM join_requests WHERE receiver_id = :receiverId AND status = 'wait'");
        $parameters = [
            "receiverId" => $receiverId
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayRequest = [];

        foreach ($results as $result) {
            $arrayRequest[] = new joinRequest($result["sender_id"], $result["receiver_id"], $result["group_id"], $result["id"]);
        }

        return $arrayRequest;
    }

    public function create(joinRequest $joinRequest) : void {
        $query = $this->db->prepare("INSERT INTO join_requests (sender_id, receiver_id, status, group_id) VALUES (:senderId, :receiverId, :status, :group_id)");
        $parameters = [
            "senderId" => $joinRequest->getSenderId(),
            "receiverId" => $joinRequest->getReceiverId(),
            "status" => $joinRequest->getStatus(),
            "group_id" => $joinRequest->getGroupId()
        ];
        $query->execute($parameters);
    }

    public function updateStatus(int $id, string $status) {
        $query = $this->db->prepare("UPDATE join_requests SET status = :status WHERE id = :id");
        $parameters = [
            "id" => $id,
            "status" => $status
        ];
        $query->execute($parameters);
    }
}