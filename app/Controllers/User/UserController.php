<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use App\Models\User\UserModel;

class UserController extends BaseController {

    private array $data = [
        "title" => "",
        "mods" => [],
    ];

    public function index(int $userId): void {
        $modModel = new ModModel();
        $userModel = new UserModel();

        $username = $userModel->getUserDetails($userId)->username;

        $this->data['title'] = $username . " profile";
        $this->data['mods'] = $modModel->getModsList(1, $userId);

        $this->view();
    }

    private function view() {
        echo view("templates/header", $this->data);
        echo view("user/user");
        echo view("templates/footer");
    }
}
