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

    public function index(int $userId): void {
        $modModel = new ModModel();
        $userModel = new UserModel();

        $this->data['user'] = $userModel->getUserDetails($userId);
        $this->data['mods'] = $modModel->getModsList(1, $userId);

        arsort($this->data['mods']);

        $this->data['title'] = $this->data['user']->username . " profile";

        echo view("user/user", $this->data);
    }
}
