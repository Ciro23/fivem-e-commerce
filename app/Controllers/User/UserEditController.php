<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\User\UserModel;

class UserEditController extends BaseController {

    protected array $data = [
        "title" => "User settings",
    ];

    public function index(string $uid): void {
        $userModel = new UserModel();

        $this->data['user'] = $userModel->getUserDetails($uid);

        echo view("user/settings", $this->data);
    }

    public function editUser(string $uid) {
        helper("form");

        if ($this->validate("user_edit")) {
            $userModel = new UserModel;
            $modDetails = $userModel->getUserDetails($uid);

            $avatar = $this->request->getFile("avatar");

            // if no avatar is uploaded, keep the old one
            $avatarExt = $modDetails->avatar_ext;

            if ($avatar->isValid() && !$avatar->hasMoved()) {
                $avatarExt = $avatar->getExtension();

                $avatar->move(ROOTPATH . "/public/assets/users_avatars/" . $uid, "avatar." . $avatarExt);
            }

            $additionalData = [
                "avatar_ext" => $avatarExt,
            ];

            $data = array_merge($this->request->getPost(), $additionalData);
            $userModel->update($uid, $data);

            return redirect("home");
        }

        $this->data['errors'] = $this->validator->listErrors("custom_errors");

        $this->index($uid);
    }
}
