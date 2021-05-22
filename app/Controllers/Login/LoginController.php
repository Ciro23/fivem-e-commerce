<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use App\Models\LoginModel;
use App\Models\UserModel;

class LoginController extends BaseController {

    /**
     * shows the login page only if the user is not logged in
     */
    public function index(): void {
        helper("form");
        $data = [];

        // in case the user is already logged in
        if ($this->session->is_logged_in) {
            redirect()->to("/");
        }

        // in case of post request
        if ($this->request->getMethod() == "post") {
            if ($this->validateAndLogin()) {
                $this->session->set([
                    "is_logged_in" => true,
                    "email" => $this->request->getVar("email"),
                ]);
            } else {
                $data['validator'] = $this->validator;
            }
        }

        echo view("login", $data);
    }

    /**
     * checks if the user input meets the validation rules
     */
    private function validateAndLogin(): bool {
        if ($this->validate("login")) {
            $signupModel = new LoginModel;
            $signupModel->login($_POST);

            return true;
        }
        return false;
    }

    public function logout(): void {
        $loginModel = new LoginModel;
        $loginModel->logout();

        redirect()->to("/");
    }
}
