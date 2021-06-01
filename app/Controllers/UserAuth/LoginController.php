<?php

namespace App\Controllers\UserAuth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends BaseController {

    private array $data = [
        "styles" => ["form_page"],
        "title" => "Login",
    ];

    /**
     * called on a get request
     * shows the login page
     */
    public function index() {
        $this->view();
    }

    /**
     * called on a post request
     * tries to login the user, if it fails shows the login page with errors messages
     */
    public function login() {
        helper("form");

        if ($this->validate("login")) {
            $this->createSession($this->request->getVar("email"));

            return redirect()->to("/");
        } else {
            $this->data['errors'] = $this->validator->listErrors();
        }

        $this->view();
    }

    private function createSession(string $email): void {
        $this->session->set([
            "is_logged_in" => true,
            "email" => $email,
        ]);
    }

    private function view(): void {
        echo view("templates/header", $this->data);
        echo view("user_auth/login");
        echo view("templates/footer");
    }

    public function logout(): RedirectResponse {
        $this->session->destroy();

        return redirect()->to("/");
    }
}
