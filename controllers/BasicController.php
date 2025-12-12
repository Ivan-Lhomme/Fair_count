<?php
class BasicController extends AbstractController{
    public function home() {
        $this->render("home.html.twig", []);
    }

    public function notFound() {
        $this->render("error/notFound.html.twig", []);
    }
}