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
}