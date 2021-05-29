<?php

namespace App\Controllers\Signup;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class SignupController extends BaseController {

    /**
     * called on a get request
     * shows the signup page only if the user is not logged in
     */
    public function index(): void {
        echo view("signup");
    }

    /**
     * called on a post request
     * tries to signup the user, if it fails shows the signup page with errors messages
     */
    public function signup() {
        helper("form");
        $data = [];

        if ($this->validate("user")) {
            $userModel = new UserModel;
            $userModel->save($this->request->getPost());

            $this->createSession($this->request->getVar("email"));

            return redirect()->to("/");
        }

        $data['validator'] = $this->validator;

        echo view("signup", $data);
    }

    // ! REPLACE EMAIL WITH ID WHEN PHP-DI WILL BE IMPLEMENTED
    private function createSession(string $email): void {
        $this->session->set([
            "is_logged_in" => true,
            "email" => $email,
        ]);
    }
}
