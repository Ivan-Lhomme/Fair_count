<?php
class AuthController extends AbstractController{
    public function home() {
        $this->render("home", []);
    }

    public function register() {
        if (isset($_SESSION["id"])) {
            $this->redirect("?route=profile");
        } else {
            if (isset($_POST["nickname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])) {
                $um = new UserManager;

                if ($um->findByEmail($_POST["email"])) {
                    $this->render("auth/register", ["errorMessage" => "Email already use"]);
                } else {
                    if ($_POST["passowrd"] === $_POST["confirmPassword"]) {
                        $um->create([
                            "nickname" => $_POST["nickname"],
                            "email" => $_POST["email"],
                            "password" => password_hash($_POST["password"], PASSWORD_BCRYPT)
                        ]);

                        $this->redirect("?route=login");
                    } else {
                        $this->render("auth/register", ["errorMessage" => "Confirmation password not egale to password", "email" => $_POST["email"]]);
                    }
                }
            } else {
                $this->render("auth/register", []);
            }
        }
    }

    public function login() {
        if (isset($_SESSION["id"])) {
            $this->redirect("?route=profile");
        } else {
            if (isset($_POST["email"]) && isset($_POST["password"])) {
                $um = new UserManager;
                $user = $um->findByEmail("email");

                if ($user) {
                    if (password_verify($_POST["password"], $user->getPassword())) {
                        $_SESSION["id"] = $user->getId();

                        $this->redirect("?route=profil");
                    } else {
                        $this->render("auth/login", ["errorMessage" => "Wrong password", "email" => $_POST["email"]]);
                    }
                } else {
                    $this->render("auth/login", ["errorMessage" => "Wrong email"]);
                }
            } else {
                $this->redirect("auth/login");
            }
        }
    }

    public function logout() : void
    {
        session_destroy();
        $this->redirect("");
    }
}