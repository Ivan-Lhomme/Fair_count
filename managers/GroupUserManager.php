<?php
class GroupUserManager extends AbstractManager{
    public function create(int $groupId, int $userId) : void {
        $query = $this->db->prepare("INSERT INTO group_users (group_id, user_id) VALUES (:groupId, :userId)");
        $parameters = [
            "groupId" => $groupId,
            "userId" => $userId
        ];
        $query->execute($parameters);
    }
}