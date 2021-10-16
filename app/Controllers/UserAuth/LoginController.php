<?php

namespace App\Controllers\UserAuth;

use App\Controllers\BaseController;
use App\Models\User\UserModel;

class LoginController extends BaseController {

    protected array $data = [
        "title" => "Login",
    ];

    /**
     * called on a get request
     * shows the login page
     */
    public function index() {
        echo view("user_auth/login", $this->data);
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
            $this->session->set([
                "is_logged_in" => true,
                "uid" => $uid,
            ]);

            return redirect("home");
        } else {
            $this->data['errors'] = $this->validator->listErrors("custom_errors");
        }

        echo view("user_auth/login", $this->data);
    }

    public function logout() {
        $this->session->destroy();

        return redirect("home");
    }
}
