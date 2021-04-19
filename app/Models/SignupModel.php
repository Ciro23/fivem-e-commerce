<?php

namespace App\Models;

use CodeIgniter\Model;

class SignupModel extends Model {

    private string $signupError = "";

    private array $userData = [
        "email" => "",
        "username" => "",
        "password" => "",
        "rePassword" => ""
    ];

    public function getSignupError(): string {
        return $this->signupError;
    }

    public function getUserEmail(): string {
        return $this->userData['email'];
    }

    public function getUsername(): string {
        return $this->userData['username'];
    }

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

    private function isUserEmailValid(UserModel $userModel): bool {
        if (empty($this->userData['email'])) {
            $this->signupError = "email-cant-be-empty";
            return false;
        }

        if (!filter_var($this->userData['email'], FILTER_VALIDATE_EMAIL)) {
            $this->signupError = "invalid-email-format";
            return false;
        }

        if ($userModel->doesUserEmailExists($this->userData['email'])) {
            // checks if the error is db related
            if ($userModel->PDOError) {
                $this->signupError = "something-went-wrong";
            } else {
                $this->signupError = "email-is-already-registered";
            }
            return false;
        }

        return true;
    }

    private function isUsernameValid(): bool {
        if (empty($this->userData['username'])) {
            $this->signupError = "username-cant-be-empty";
            return false;
        }

        if (!preg_match("/^[A-Za-z0-9]+$/", $this->userData['username'])) {
            $this->signupError = "username-can-only-contains-alphanumeric-characters";
            return false;
        }

        if (strlen($this->userData['username']) < 4 || strlen($this->userData['username']) > 20) {
            $this->signupError = "username-length-must-be-between-4-and-20";
            return false;
        }

        return true;
    }

    private function isUserPasswordValid(): bool {
        if (empty($this->userData['password'])) {
            $this->signupError = "password-cant-be-empty";
            return false;
        }

        if (strlen($this->userData['password']) < 6 || strlen($this->userData['password']) > 72) {
            $this->signupError = "password-length-must-be-between-6-and-72";
            return false;
        }

        if ($this->userData['password'] != $this->userData['rePassword']) {
            $this->signupError = "passwords-do-not-match";
            return false;
        }

        return true;
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
