<?php
class joinRequest{
    public function __construct(private int $senderId, private int $receiverId, private int $groupId, private ?int $id = null, private string $status = "wait") {}

    public function getSenderId()
    {
        return $this->senderId;
    }
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    public function getReceiverId()
    {
        return $this->receiverId;
    }
    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    public function getGroupId()
    {
        return $this->groupId;
    }
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function accept() {
        $this->status = "accepted";
    }
    public function refuse() {
        $this->status = "refused";
    }
}