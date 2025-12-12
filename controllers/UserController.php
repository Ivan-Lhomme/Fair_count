<?php
class UserController extends AbstractController{
    public function profile() {
        if (isset($_SESSION["id"])) {
            $um = new UserManager;
            $gm = new GroupManager;
            $em = new ExpenseManager;
            $rm = new RefundManager;

            $user = $um->findById($_SESSION["id"]);

            $groups_tmp = $gm->findByOwnerIdLimited($_SESSION["id"], 3);
            $groups = [];

            foreach ($groups_tmp as $group) {
                $expenses = $em->findByGroupId($group["id"]);
                $refunds = $rm->findByGroupId($group["id"]);
                $amount = 0;

                foreach ($expenses as $expense) {
                    $amount -= $expense->getAmount();
                }

                foreach ($refunds as $refund) {
                    $amount += $refund->getAmount();
                }

                $expenses = $em->findByGroupIdLimited($group["id"], 3);

                $groups[] = [
                    "name" => $group["name"],
                    "amount" => $amount,
                    "expenses" => $expenses
                ];
            }

            $this->render("user/profile.html.twig", [
                "nickname" => $user->getNickName(),
                "groups" => $groups,
                "money" => $user->getMoney()
            ]);
        } else {
            $this->redirect("?route=login");
        }
    }
}