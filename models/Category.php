<?php
class Category{
    public function __construct(private string $name, private ?int $id = null) {}

    public function getName() {
        return $this->name;
    }
    public function setName(string $name) {
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = $id;
    }

    public function toArray() : array {
        return [
            "id" => $this->id,
            "name" => $this->name
        ];
    }
}