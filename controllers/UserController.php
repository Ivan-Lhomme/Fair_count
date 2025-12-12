<?php
class UserController extends AbstractController{
    public function profile() {
        if (isset($_SESSION["id"])) {
            $this->render("user/profile.html.twig", []);
        } else {
            $this->redirect("?route=login");
        }
    }
}