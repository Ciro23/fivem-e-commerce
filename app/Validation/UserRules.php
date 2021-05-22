<?php

namespace App\Validation;

use App\Models\UserModel;

class UserRules {

    /**
     * checks if a specified user field is unique
     * 
     * @param string $parameter the user field to check
     * @param string $value the value of the field
     * 
     * @return bool
     */
    public function is_unique(string $parameter, string $value): bool {
        $userModel = new UserModel;

        return $userModel->doesUserExists($parameter, $value);
    }

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
