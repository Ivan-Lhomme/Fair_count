<?php
class Router{
    public function handleRequest(array $get) {
        $bc = new BasicController;
        $ac = new AuthController;
        $uc = new UserController;

        if (isset($get["route"])) {
            if ($get["route"] === "login") {
                $ac->login();
            } else if ($get["route"] === "register") {
                $ac->register();
            } else if ($get["route"] === "logout") {
                $ac->logout();
            } else if ($get["route"] === "profile") {
                $uc->profile();
            } else if ($get["route"] === "add-money") {
                $uc->addMoney();
            } else if ($get["route"] === "groups") {
                $uc->groups();
            } else {
                $bc->notFound();
            }
        } else {
            $bc->home();
        }
    }
}