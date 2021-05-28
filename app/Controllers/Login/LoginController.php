<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends BaseController {

    /**
     * shows the login page only if the user is not logged in
     */
    public function index() {
        helper("form");
        $data = [];

        // in case the user is already logged in
        if ($this->session->is_logged_in) {
            return redirect()->to("/");
        }

        // in case of post request
        if ($this->request->getMethod() == "post") {
            if ($this->validate("login")) {
                $this->session->set([
                    "is_logged_in" => true,
                    "email" => $this->request->getVar("email"),
                ]);
            } else {
                $data['validator'] = $this->validator;
            }
        }

        echo view("login", $data);
    }

    public function logout(): RedirectResponse {
        $this->session->destroy();

        return redirect()->to("/");
    }
}
