<?php

namespace App\Validation;

use App\Models\UserModel;

class UserRules {

    /**
     * checks if one user with both specifies email and password exists
     * 
     * @param string $email
     * @param string $password
     * 
     * @return bool
     */
    public function are_credentials_correct(string $email, string $password): bool {
        $userModel = new UserModel;
        $hashedPassword = $userModel->getUserPasswordByEmail($email);
        
        return password_verify($password, $hashedPassword);
    }
}
