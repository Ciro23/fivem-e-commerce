<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends BaseController {

    private array $data = [
        "styles" => ["login-signup"],
        "title" => "Login",
    ];

    /**
     * called on a get request
     * shows the login page
     */
    public function index() {
        $this->view($this->data);
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
            $this->data['validator'] = $this->validator;
        }

        $this->view($this->data);
    }

    private function createSession(string $email): void {
        $this->session->set([
            "is_logged_in" => true,
            "email" => $email,
        ]);
    }

    private function view(array $data): void {
        echo view("templates/header", $data);
        echo view("login");
        echo view("templates/footer");
    }

    public function logout(): RedirectResponse {
        $this->session->destroy();

        return redirect()->to("/");
    }
}
