<?php
class GroupController extends AbstractController{
    public function group() {
        if (isset($_SESSION["id"])) {
            $gm = new GroupManager;
            
            if ($gm->inGroup($_GET["groupId"], $_SESSION["id"])) {
                $gm = new GroupManager;
                $um = new UserManager;
                $em = new ExpenseManager;
                $rm = new RefundManager;

                $group_tmp = $gm->findOne($_GET["groupId"]);
                $groupOwner = $um->findById($group_tmp["ownerId"]);

                $arrayUsers = $um->findByGroupId($group_tmp["id"], $groupOwner->getId());
                $arrayExpenses = $em->findByGroupId($group_tmp["id"]);
                $arrayRefunds = $rm->findByGroupId($group_tmp["id"]);

                $group = new Group($group_tmp["name"], $groupOwner->getNickName(), $arrayUsers, $arrayExpenses, $arrayRefunds, $group_tmp["id"]);

                $amount = 0;

                foreach ($group->getExpenses() as $expense) {
                    $amount -= $expense->getAmount();
                }

                $users = [];
                foreach ($group->getUsers() as $user) {
                    $userAmount = round($amount / count($group->getUsers()), 2);
                    $user_tmp = $user->toArray();
                    $refunds = $rm->findByOwnerIdAndGroupId($user_tmp["id"], $group->getId());

                    foreach ($refunds as $refund) {
                        $userAmount += $refund->getAmount();
                    }

                    $user_tmp["amount"] = $userAmount;
                    $users[] = $user_tmp;
                }

                foreach ($group->getRefunds() as $refund) {
                    $amount += $refund->getAmount();
                }

                $expenses = [];
                foreach ($group->getExpenses() as $expense) {
                    $expense_tmp = $expense->toArray();
                    $expense_tmp["ownerName"] = $um->findById($expense_tmp["ownerId"])->getNickName();
                    $expenses[] = $expense_tmp;
                }

                $refunds = [];
                foreach ($group->getRefunds() as $refund) {
                    $refund_tmp = $refund->toArray();
                    $refund_tmp["ownerName"] = $um->findById($refund_tmp["ownerId"])->getNickName();
                    $refunds[] = $refund_tmp;
                }

                $this->render("group/group.html.twig", [
                    "groupId" => $group->getId(),
                    "goupName" => $group->getName(),
                    "ownerName" => $group->getOwnerName(),
                    "montant" => $amount,
                    "members" => $users,
                    "expenses" => $expenses,
                    "refunds" => $refunds
                ]);
            } else {
                $this->redirect("?route=groups");
            }
        } else {
            $this->redirect(".");
        }
    }

    public function addExpense() {
        if (isset($_SESSION["id"])) {
            $gm = new GroupManager;

            if ($gm->inGroup($_GET["groupId"], $_SESSION["id"])) {
                if (isset($_POST["reason"]) && isset($_POST["categoryId"]) && isset($_POST["amount"]) && isset($_POST["ownerId"])) {
                    $em = new ExpenseManager;
                    $em->create([
                        "reason" => $_POST["reason"],
                        "categoryId" => $_POST["categoryId"],
                        "amount" => $_POST["amount"],
                        "ownerId" => $_POST["ownerId"],
                        "groupId" => $_POST["groupId"]
                    ]);

                    $this->redirect("?route=group&groupId=".$_POST["groupId"]);
                } else {
                    $this->render("group/addExpense.html.twig", []);
                }
            } else {
                $this->redirect("?route=groups");
            }
        } else {
            $this->redirect(".");
        }
    }
}