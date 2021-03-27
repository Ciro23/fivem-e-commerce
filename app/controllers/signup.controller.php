<?php

class SignupController extends Mvc\Controller {

    /**
     * shows the signup page
     */
    public function index() {
        if (!isset($_SESSION['id'])) {
            $this->view("signup");
        } else {
            header("Location: /");
        }
    }

    /**
     * perform the signup action
     */
    public function signup() {
        $signupModel = $this->model("signup");

        if ($signupModel->signup()) {
            header("Location: ");
            // ! success
        } else {
            header("Location: ");
            // ! failure
        }
    }
}