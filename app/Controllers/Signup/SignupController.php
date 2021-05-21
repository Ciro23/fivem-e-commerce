<?php

namespace App\Controllers\Signup;

use App\Controllers\BaseController;
use Config\Services;
use App\Models\SignupModel;
use App\Models\UserModel;

class SignupController extends BaseController {

    /**
     * shows the signup page only if the user is not logged in
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
            if ($this->validateAndSignup()) {
                $this->session->set([
                    "is_logged_in" => true,
                    "email" => $this->request->getVar("email"),
                ]);
            } else {
                $data['validator'] = $this->validator;
            }
        }

        echo view("signup", $data);
    }

    /**
     * checks if the user input meets the signup rules
     */
    private function validateAndSignup(): bool {
        if ($this->validate("signup")) {
            $signupModel = new SignupModel;
            $signupModel->signup($_POST);

            return true;
        }
        return false;
    }
}
