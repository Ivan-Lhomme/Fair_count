<?php
class AuthController extends AbstractController{
    public function register() {
        if (isset($_SESSION["id"])) {
            $this->redirect("?route=profile");
        } else {
            if (isset($_POST["nickName"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])) {
                $um = new UserManager;
                if ($um->findByNickName($_POST["nickName"])) {
                    $this->render("auth/register.html.twig", ["error" => "nickName"]);
                } else {
                    if ($um->findByEmail($_POST["email"])) {
                        $this->render("auth/register.html.twig", ["error" => "email", "nickName" => $_POST["nickName"]]);
                    } else {
                        if ($_POST["password"] === $_POST["confirmPassword"]) {
                            $um->create([
                                "nickname" => $_POST["nickName"],
                                "email" => $_POST["email"],
                                "password" => password_hash($_POST["password"], PASSWORD_BCRYPT)
                            ]);

                            $this->redirect("?route=login");
                        } else {
                            $this->render("auth/register.html.twig", ["error" => "confirmPassword", "nickName" => $_POST["nickName"], "email" => $_POST["email"]]);
                        }
                    }
                }
            } else {
                $this->render("auth/register.html.twig", []);
            }
        }
    }

    public function login() {
        if (isset($_SESSION["id"])) {
            $this->redirect("?route=profile");
        } else {
            if (isset($_POST["email"]) && isset($_POST["password"])) {
                $um = new UserManager;
                $user = $um->findByEmail($_POST["email"]);

                if ($user) {
                    if (password_verify($_POST["password"], $user->getPassword())) {
                        $_SESSION["id"] = $user->getId();

                        $this->redirect("?route=profile");
                    } else {
                        $this->render("auth/login.html.twig", ["error" => "password", "value" => $_POST["email"]]);
                    }
                } else {
                    $this->render("auth/login.html.twig", ["error" => "email"]);
                }
            } else {
                $this->render("auth/login.html.twig", []);
            }
        }
    }

    public function logout() : void
    {
        session_destroy();
        $this->redirect(".");
    }
}