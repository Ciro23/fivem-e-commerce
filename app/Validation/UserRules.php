<?php

namespace App\Validation;

use App\Models\User\UserModel;

class UserRules {

    /**
     * checks if one user with both specifies email and password exists
     * 
     * @param string $email
     * @param string $password
     * 
     * @return bool
     */
    public function are_credentials_correct(string $email, string $fields, array $data): bool {
        $userModel = new UserModel;
        $hashedPassword = $userModel->getUserPasswordByEmail($email);

        return password_verify($data['password'], $hashedPassword);
    }
}
