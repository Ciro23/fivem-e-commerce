<?php

namespace App\Controllers\UserAuth;

use App\Controllers\BaseController;
use App\Models\User\UserModel;

class SignupController extends BaseController {

    protected array $data = [
        "title" => "Signup",
    ];

    /**
     * called on a get request
     * shows the signup page only if the user is not logged in
     */
    public function index(): void {
        echo view("user_auth/signup", $this->data);
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

            $this->session->set([
                "is_logged_in" => true,
                "uid" => $userModel->getInsertID(),
            ]);

            return redirect("home");
        }

        $this->data['errors'] = $this->validator->listErrors("custom_errors");

        echo view("user_auth/signup", $this->data);
    }
}
