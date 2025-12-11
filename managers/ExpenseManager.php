<?php
class ExpenseManager extends AbstractManager{
    public function findById(int $id) : Expense {
        $query = $this->db->prepare("SELECT expenses.id, expenses.reason, expenses.amount, expenses.owner_id, expenses.group_id, categories.name as 'categorie_name' FROM expenses JOIN categories ON expenses.category_id = categories.id WHERE expenses.id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return new Expense($result["reason"], $result["amount"], $result["owner_id"], $result["categorie_name"], $result["id"]);
    }

    public function findByGroupId(int $groupId) : array {
        $query = $this->db->prepare("SELECT expenses.id, expenses.reason, expenses.amount, expenses.owner_id, expenses.group_id, categories.name as 'categorie_name' FROM expenses JOIN categories ON expenses.category_id = categories.id WHERE expenses.group_id = :groupId");
        $parameters = [
            "groupId" => $groupId
        ];
        $query->execute($parameters);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayExpense = [];

        foreach ($results as $result) {
            $arrayExpense[] = new Expense($result["reason"], $result["amount"], $result["owner_id"], $result["categorie_name"], $result["id"]);
        }

        return $arrayExpense;
    }

    public function findAll() : array {
        $query = $this->db->prepare("SELECT expenses.id, expenses.reason, expenses.amount, expenses.owner_id, expenses.group_id, categories.name as 'categorie_name' FROM expenses JOIN categories ON expenses.category_id = categories.id");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayExpense = [];

        foreach ($results as $result) {
            $arrayExpense[] = new Expense($result["reason"], $result["amount"], $result["owner_id"], $result["categorie_name"], $result["id"]);
        }

        return $arrayExpense;
    }
}