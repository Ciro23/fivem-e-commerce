<?php

namespace App\Controllers\Signup;

use App\Controllers\BaseController;
use App\Models\SignupModel;
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
            if ($this->validateAndSignup()) {
                $this->session->set([
                    "is_logged_in" => true,
                    "email" => $this->request->getVar("email"),
                ]);
                
                return redirect()->to("/");
            } else {
                $data['validator'] = $this->validator;
            }
        }

        echo view("signup", $data);
    }

    /**
     * checks if the user input meets the validation rules
     * 
     * @return bool
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
