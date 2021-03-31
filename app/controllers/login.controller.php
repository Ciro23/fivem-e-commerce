<?php

class LoginController extends Mvc\Controller {

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
        $userModel = $this->model("user");

        if ($loginModel->login($userModel)) {
            header("Location: ");
            // ! success
        } else {
            header("Location: ");
            // ! failure
        }
    }
}
