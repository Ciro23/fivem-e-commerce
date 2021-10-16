<?php

namespace App\Libraries;

use App\Models\User\UserModel;

class IsUserAdmin {

    public function __construct() {
        $userModel = new UserModel();
        $id = session("uid");

        return $userModel->isUserAdmin($id);
    }
}
