<?php

namespace App\Controllers\Signup;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class SignupController extends BaseController {

    /**
     * shows the signup page only if the user is not logged in
     */
    public function index() {
        helper("form");
        $data = [];

        // in case the user is already logged in
        if ($this->session->is_logged_in) {
            return redirect()->to("/");
        }

        // in case of post request
        // tries to validate the user input
        // in case of success, creates the session and redirect
        // otherwise save the validator object in the data array
        if ($this->request->getMethod() == "post") {
            if ($this->tryToValidateAndSignup()) {
                $this->createSession($this->request->getVar("email"));
                return redirect()->to("/");
            }
            $data['validator'] = $this->validator;
        }

        echo view("signup", $data);
    }

    private function tryToValidateAndSignup(): bool {
        if ($this->validate("user")) {
            $userModel = new UserModel;
            $userModel->save($this->request->getPost());
            
            return true;
        } else {
            return false;
        }
    }

    // ! REPLACE EMAIL WITH ID WHEN PHP-DI WILL BE IMPLEMENTED
    private function createSession(string $email): void {
        $this->session->set([
            "is_logged_in" => true,
            "email" => $email,
        ]);
    }
}
