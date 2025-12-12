<?php
class UserController extends AbstractController{
    public function profile() {
        if (isset($_SESSION["id"])) {
            if ($_SESSION["id"] === $_GET["id"]) {
                $this->render("user/profile.html.twig", []);
            } else {
                $this->redirect("");
            }
        } else {
            $this->redirect("?route=login");
        }
    }
}