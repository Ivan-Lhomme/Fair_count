<?php
class CategoryManager extends AbstractManager{
    public function findAll() {
        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayCategories = [];

        foreach ($results as $result) {
            $arrayCategories[] = new Category($result["name"], $result["id"]);
        }

        return $arrayCategories;
    }
}