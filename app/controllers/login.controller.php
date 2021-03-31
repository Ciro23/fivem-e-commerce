<?php

class LoginController extends Mvc\Controller {

    /**
     * shows the login page
     */
    public function index() {
        if (!isset($_SESSION['uid'])) {
            // saves the error, the email and the username if something goes wrong
            $data['form']['error'] = $_GET['error'] ?? "";
            $data['form']['email'] = $_GET['email'] ?? "";
            $data['form']['username'] = $_GET['username'] ?? "";

            // formats the error
            $data['form']['error'] = SignupModel::formatError($data['form']['error']);

            $this->view("login", $data);
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
            header("Location: /login/?error="
                . $loginModel->error
                . "&email="
                . $loginModel->email);
        }
    }

    /**
     * performs the logout action
     */
    public function logout() {
        $loginModel = $this->model("login");
        $loginModel->logout();

        header("Location: /");
    }
}
