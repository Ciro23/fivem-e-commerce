<?php

namespace App\Controllers\UserAuth;

use App\Controllers\BaseController;
use App\Models\User\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class SignupController extends BaseController {

    private array $data = [
        "title" => "Signup",
    ];

    /**
     * called on a get request
     * shows the signup page only if the user is not logged in
     */
    public function index(): void {
        $this->view();
    }

    /**
     * called on a post request
     * tries to signup the user, if it fails shows the signup page with errors messages
     */
    public function signup() {
        helper("form");

        if ($this->validate("user")) {
            $userModel = new UserModel;
            $userModel->save($this->request->getPost());

            $this->createSession($userModel->getInsertID());

            return redirect()->to("/");
        }

        $this->data['errors'] = $this->validator->listErrors("custom_errors");

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
        echo view("user_auth/signup");
        echo view("templates/footer");
    }
}
