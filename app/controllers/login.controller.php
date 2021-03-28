<?php

class LoginController extends Mvc\Model {

    /**
     * shows the login page
     */
    public function index() {
        if (!isset($_SESSION['uid'])) {
            $this->view("login");
        } else {
            header("Location: /");
        }
    }

    /**
     * performs the login action
     */
    public function login() {
        $loginModel = $this->model("login");

        if ($loginModel->login()) {
            header("Location: ");
            // ! success
        } else {
            header("Location: ");
            // ! failure
        }
    }
}