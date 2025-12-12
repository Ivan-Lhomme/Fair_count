<?php
class BasicController extends AbstractController{
    public function home() {
        $this->render("home", []);
    }

    public function notFound() {
        $this->render("error/notFound", []);
    }
}