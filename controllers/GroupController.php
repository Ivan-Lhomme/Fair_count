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
                $jrm = new joinRequestManager;

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

                $arrayJoinRequests = $jrm->findByGroupId($_GET["groupId"]);
                $joinRequests = [];
                foreach ($arrayJoinRequests as $memberRequest) {
                    $joinRequests[] = ["nickName" => $um->findById($memberRequest->getReceiverId())->getNickName(), "status" => $memberRequest->getStatus()];
                }

                $this->render("group/group.html.twig", [
                    "groupId" => $group->getId(),
                    "goupName" => $group->getName(),
                    "ownerName" => $group->getOwnerName(),
                    "montant" => $amount,
                    "members" => $users,
                    "expenses" => $expenses,
                    "refunds" => $refunds,
                    "joinRequests" => $joinRequests
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
                if (isset($_POST["reason"]) && isset($_POST["categoryId"]) && isset($_POST["amount"])) {
                    $rm = new ExpenseManager;
                    $rm->create([
                        "reason" => $_POST["reason"],
                        "categoryId" => $_POST["categoryId"],
                        "amount" => $_POST["amount"],
                        "ownerId" => $_SESSION["id"],
                        "groupId" => $_GET["groupId"]
                    ]);

                    $this->redirect("?route=group&groupId=".$_GET["groupId"]);
                } else {
                    $cm = new CategoryManager;
                    $categories = $cm->findAll();
                    $arrayCategories = [];

                    foreach ($categories as $category) {
                        $arrayCategories[] = $category->toArray();
                    }

                    $this->render("group/addExpense.html.twig", ["categories" => $arrayCategories, "groupId" => $_GET["groupId"]]);
                }
            } else {
                $this->redirect("?route=groups");
            }
        } else {
            $this->redirect(".");
        }
    }

    public function addRefund() {
        if (isset($_SESSION["id"])) {
            $gm = new GroupManager;

            if ($gm->inGroup($_GET["groupId"], $_SESSION["id"])) {
                if (isset($_POST["amount"])) {
                    $rm = new RefundManager;
                    $um = new UserManager;

                    $rm->create([
                        "amount" => $_POST["amount"],
                        "ownerId" => $_SESSION["id"],
                        "groupId" => $_GET["groupId"]
                    ]);

                    $um->subMoney($_SESSION["id"], $_POST["amount"]);

                    $this->redirect("?route=group&groupId=".$_GET["groupId"]);
                } else {
                    $this->render("group/addRefund.html.twig", ["groupId" => $_GET["groupId"]]);
                }
            } else {
                $this->redirect("?route=groups");
            }
        } else {
            $this->redirect(".");
        }
    }

    public function addGroup() {
        if (isset($_SESSION["id"])) {
            if ($_POST["name"]) {
                $gm = new GroupManager;
                $gm->create(["name" => $_POST["name"], "ownerId" => $_SESSION["id"]]);

                $gum = new GroupUserManager;
                $gum->create($gm->findLast()["id"], $_SESSION["id"]);

                $this->redirect("?route=groups");
            } else {
                $this->render("group/addGroup.html.twig", []);
            }
        } else {
            $this->redirect(".");
        }
    }

    public function addMember() {
        if (isset($_SESSION["id"])) {
            if (isset($_POST["receiverName"])) {
                $um = new UserManager;
                $user = $um->findByNickName($_POST["receiverName"]);

                if ($user) {
                    $jrm = new joinRequestManager;
                    $jrm->create(new joinRequest($_SESSION["id"], $user->getId(), $_GET["groupId"]));

                    $this->redirect("?route=group&groupId=".$_GET["groupId"]);
                } else {
                    $this->render("group/addMember.html.twig", ["error" => "receiverName"]);
                }
            } else {
                $gm = new GroupManager;

                $this->render("group/addMember.html.twig", ["groupName" => $gm->findOne($_GET["groupId"])["name"], "groupId" => $_GET["groupId"]]);
            }
        } else {
            $this->redirect(".");
        }
    }
}