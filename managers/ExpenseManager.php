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

    public function create(array $expense) : void {
        $query = $this->db->prepare("INSERT INTO expenses (reason, amount, owner_id, category_id, group_id) VALUES (:reason, :amount, :owner_id, :category_id, :group_id)");
        $parameters = [
            "reason" => $expense["reason"],
            "amount" => $expense["amount"],
            "owner_id" => $expense["owner_id"],
            "category_id" => $expense["category_id"],
            "group_id" => $expense["group_id"]
        ];
        $query->execute($parameters);
    }

    public function update(array $expense) : void {
        $query = $this->db->prepare("UPDATE expenses SET reason = :reason, amount = :amount, owner_id = :owner_id, category_id = :category_id, group_id = :group_id WHERE id = :id");
        $parameters = [
            "id" => $expense["id"],
            "reason" => $expense["reason"],
            "amount" => $expense["amount"],
            "owner_id" => $expense["owner_id"],
            "category_id" => $expense["category_id"],
            "group_id" => $expense["group_id"]
        ];
        $query->execute($parameters);
    }

    public function delete(int $id) : void {
        $query = $this->db->prepare("DELETE FROM expenses WHERE id = :id");
        $parameters = [
            "id" => $id,
        ];
        $query->execute($parameters);
    }
}