<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\UserModel;

class LoginController extends BaseController {

    /**
     * shows the login page only if the user is not logged in
     */
    public function index(): void {
        if (!isset($_SESSION['uid'])) {
            // saves the error, the email if something goes wrong
            $data['form']['error'] = $_GET['error'] ?? "";
            $data['form']['email'] = $_GET['email'] ?? "";

            // formats the error
            $data['form']['error'] = \StringHelper::formatError($data['form']['error']);

            echo view("login", $data);
        } else {
            header("Location: /");
        }
    }

    public function login(): void {
        $loginModel = new LoginModel;
        $userModel = new UserModel;

        // tries to execute LoginModel::login(), which returns true in case of success, false otherwise
        if ($loginModel->login($_POST, $userModel)) {
            header("Location: /");
        } else {
            header("Location: /login/?error="
                . $loginModel->getLoginError()
                . "&email="
                . $loginModel->getUserEmail());
        }
    }

    public function logout(): void {
        $loginModel = new LoginModel;
        $loginModel->logout();

        header("Location: /");
    }
}
