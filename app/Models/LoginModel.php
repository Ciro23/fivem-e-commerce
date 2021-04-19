<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model {

    private string $loginError = "";

    private array $userData = [
        "email" => "",
        "password" => ""
    ];

    public function getLoginError(): string {
        return $this->loginError;
    }

    public function getUserEmail(): string {
        return $this->userData['email'];
    }

    public function login(array $inputData, UserModel $userModel): bool {
        $this->userData = \InputHelper::getFormInput($this->userData, $inputData);

        // checks for errors
        if (
            !$this->isUserEmailValid()
            || !$this->isUserPasswordValid()
        ) {
            return false;
        }

        // checks if the email and password are correct and creates the session
        if ($this->areCredentialsCorrect($userModel)) {
            $_SESSION['uid'] = $userModel->getUserIdByEmail($this->userData['email']);
            return true;
        }

        // in case of wrong credentials
        if ($userModel->PDOError) {
            $this->loginError = "something-went-wrong";
        } else {
            $this->loginError = "credentials-are-not-correct";
        }

        return false;
    }

    public function logout(): void {
        session_destroy();
    }

    private function isUserEmailValid(): bool {
        if (empty($this->userData['email'])) {
            $this->loginError = "email-cant-be-empty";
            return false;
        }

        return true;
    }

    private function isUserPasswordValid(): bool {
        if (empty($this->userData['password'])) {
            $this->loginError = "password-cant-be-empty";
            return false;
        }

        return true;
    }

    private function areCredentialsCorrect(UserModel $userModel): bool {
        if (password_verify($this->userData['password'], $userModel->getUserPasswordByEmail($this->userData['email']))) {
            return true;
        }
        
        return false;
    }
}
