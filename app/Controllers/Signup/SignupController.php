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
        $session = session();
        helper("form");

        // in case the user is already logged in
        if (isset($session->uid)) {
            redirect()->to("/");
        }

        $data = [];

        // in case of post request
        if ($this->request->getMethod() == "post") {
            if ($this->validateAndSignup()) {
                $session->set([
                    "is_logged_in" => true,
                ]);
            } else {
                $data['validator'] = $this->validator->listErrors();
            }
        }

        echo view("signup", $data);
    }

    /**
     * checks if the user input meets the signup rules
     */
    public function validateAndSignup(): bool {
        if ($this->validate("signup")) {
            $signupModel = new SignupModel;
            $signupModel->signup($_POST);

            return true;
        }
        return false;
    }
}
