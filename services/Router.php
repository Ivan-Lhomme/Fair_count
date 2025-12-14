<?php
class Router{
    public function handleRequest(array $get) {
        $bc = new BasicController;
        $ac = new AuthController;
        $uc = new UserController;
        $gc = new GroupController;
        $jrc = new joinRequestController;

        if (isset($get["route"])) {
            if ($get["route"] === "login") {
                $ac->login();
            } else if ($get["route"] === "register") {
                $ac->register();
            } else if ($get["route"] === "logout") {
                $ac->logout();
            } else if ($get["route"] === "profile") {
                $uc->profile();
            } else if ($get["route"] === "groups") {
                $uc->groups();
            } else if ($get["route"] === "group") {
                if (isset($get["groupId"])) {
                    $gc->group();
                } else {
                    $bc->home();
                }
            } else if ($get["route"] === "add-money") {
                $uc->addMoney();
            } else if ($get["route"] === "add-group") {
                $gc->addGroup();
            } else if ($get["route"] === "add-expense") {
                if (isset($get["groupId"])) {
                    $gc->addExpense();
                } else {
                    $bc->home();
                }
            } else if ($get["route"] === "add-refund") {
                if (isset($get["groupId"])) {
                    $gc->addRefund();
                } else {
                    $bc->home();
                }
            } else if ($get["route"] === "add-member") {
                if (isset($get["groupId"])) {
                    $gc->addMember();
                } else {
                    $bc->home();
                }
            } else if ($get["route"] === "joinRequest-accept") {
                if (isset($get["joinRequestId"])) {
                    $jrc->accept();
                } else {
                    $uc->profile();
                }
            } else if ($get["route"] === "joinRequest-refuse") {
                if (isset($get["joinRequestId"])) {
                    $jrc->refuse();
                } else {
                    $uc->profile();
                }
            } else {
                $bc->notFound();
            }
        } else {
            $bc->home();
        }
    }
}