<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use App\Models\User\UserModel;

class UserController extends BaseController {

    protected array $data = [
        "title" => "",
        "mods" => [],
    ];

    public function index(string $userId): void {
        $modModel = new ModModel();
        $userModel = new UserModel();

        $this->data['user'] = $userModel->getUserDetails($userId);
        $this->data['mods'] = $modModel->getModsList(1, $userId, order: "older");

        $this->data['title'] = $this->data['user']->username . " profile";

        echo view("user/user", $this->data);
    }
}
