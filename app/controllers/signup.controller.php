<?php

class SignupController extends Mvc\Controller {

    /**
     * shows the signup page
     */
    public function index() {
        if (!isset($_SESSION['uid'])) {
            // saves the error, the email and the username if something goes wrong
            $data['form']['error'] = $_GET['error'] ?? "";
            $data['form']['email'] = $_GET['email'] ?? "";
            $data['form']['username'] = $_GET['username'] ?? "";

            // formats the error
            $data['form']['error'] = StringHelper::formatError($data['form']['error']);

            $this->view("signup", $data);
        } else {
            header("Location: /");
        }
    }

    /**
     * performs the signup action
     */
    public function signup() {
        $signupModel = $this->model("Signup");
        $userModel = $this->model("User");

        if ($signupModel->signup($userModel)) {
            header("Location: ");
            // ! success
        } else {
            header("Location: /signup/?error="
                . $signupModel->error
                . "&email="
                . $signupModel->data['email']
                . "&username="
                . $signupModel->data['username']);
        }
    }
}
