<?php

namespace App\Controllers\Signup;

use App\Controllers\BaseController;
use App\Models\SignupModel;
use App\Models\UserModel;

class SignupController extends BaseController {

    /**
     * shows the signup page only if the user is not logged in
     */
    public function index(): void {
        if (!isset($_SESSION['uid'])) {
            helper("form");
            library("form_validation");

            if ($this->form_validation->run() === false) {
                echo view("signup");
            } else {
                echo "success!";
            }
        } else {
            header("Location: /");
        }
    }

    public function signup(): void {
        $signupModel = new SignupModel;
        $userModel = new UserModel;

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
