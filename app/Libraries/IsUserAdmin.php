<?php

namespace App\Libraries;

use App\Models\User\UserModel;

class IsUserAdmin {

    public function isUserAdmin() {
        $userModel = new UserModel();
        $id = session("uid");

        return $userModel->isUserAdmin($id);
    }
}
