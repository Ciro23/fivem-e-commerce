<?php

class SignupController extends Mvc\Controller {

    /**
     * shows the signup page
     */
    public function index() {
        if (!isset($_SESSION['uid'])) {
            $this->view("signup");
        } else {
            header("Location: /");
        }
    }

    /**
     * performs the signup action
     */
    public function signup() {
        $signupModel = $this->model("signup");
        $userModel = $this->model("user");

        if ($signupModel->signup($userModel)) {
            header("Location: ");
            // ! success
        } else {
            header("Location: /signup/?error="
                . $signupModel->signupError
                . "&email="
                . $signupModel->email
                . "&username="
                . $signupModel->username);
        }
    }
}
