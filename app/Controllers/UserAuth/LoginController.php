<?php

namespace App\Controllers\UserAuth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\User\UserModel;

class LoginController extends BaseController {

    private array $data = [
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
            $userModel = new UserModel;

            $uid = $userModel->getUserIdByEmail($this->request->getVar("email"));
            $this->createSession($uid);

            return redirect()->to("/");
        } else {
            $this->data['errors'] = $this->validator->listErrors("custom_errors");
        }

        $this->view();
    }

    private function createSession(int $uid): void {
        $this->session->set([
            "is_logged_in" => true,
            "uid" => $uid,
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
