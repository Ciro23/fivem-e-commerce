<?php

namespace App\Models;

use CodeIgniter\Model;

class SignupModel extends Model {

    private array $userData = [
        "email" => "",
        "username" => "",
        "password" => "",
        "rePassword" => ""
    ];

    public function signup(array $inputData, UserModel $userModel): bool {
        // gets the form input
        $this->userData = \InputHelper::getFormInput($this->userData, $inputData);

        // checks for errors
        if (
            !$this->isUserEmailValid($userModel)
            || !$this->isUsernameValid()
            || !$this->isUserPasswordValid()
        ) {
            return false;
        }

        // hashes the password
        $this->userData['password'] = password_hash($this->userData['password'], PASSWORD_BCRYPT);

        // insert the user userData into the db and creates the session
        if ($this->insertIntoDb()) {
            $_SESSION['uid'] = $this->lastInsertId("users");
            return true;
        }
        // in case of query failure
        $this->signupError = "something-went-wrong";
        return false;
    }

    private function insertIntoDb(): bool {
        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        $params = [$this->userData['email'], $this->userData['username'], $this->userData['password']];

        // tries to run the query
        if ($this->executeStmt($sql, $params)) {
            return true;
        }
        
        return false;
    }
}
