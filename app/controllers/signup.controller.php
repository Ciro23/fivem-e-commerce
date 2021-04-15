<?php

class SignupController extends Mvc\Controller {

    /**
     * shows the signup page only if the user is not logged in
     */
    public function index(): void {
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

    public function signup(): void {
        $signupModel = $this->model("Signup");
        $userModel = $this->model("User");

        // tries to execute SignupModel::signup(), which returns true in case of success, false otherwise
        if ($signupModel->signup($_POST, $userModel)) {
            header("Location: /");
        } else {
            header("Location: /signup/?error="
                . $signupModel->getSignupError()
                . "&email="
                . $signupModel->getUserEmail()
                . "&username="
                . $signupModel->getUsername());
        }
    }
}
