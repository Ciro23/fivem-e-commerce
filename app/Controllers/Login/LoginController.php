<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends BaseController {

    /**
     * called on a get request
     * shows the login page
     */
    public function index() {
        echo view("login");
    }

    /**
     * called on a post request
     * tries to login the user, if it fails shows the login page with errors messages
     */
    public function login() {
        helper("form");
        $data = [];

        if ($this->validate("login")) {
            $this->createSession($this->request->getVar("email"));

            return redirect()->to("/");
        } else {
            $data['validator'] = $this->validator;
        }

        echo view("login", $data);
    }

    private function createSession(string $email): void {
        $this->session->set([
            "is_logged_in" => true,
            "email" => $email,
        ]);
    }

    public function logout(): RedirectResponse {
        $this->session->destroy();

        return redirect()->to("/");
    }
}
