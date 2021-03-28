<?php

class LoginModel extends Mvc\Model {

    /**
     * @var string|bool $loginError
     */
    public $loginError = false;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $password
     */
    private $password;

    /**
     * performs the login action
     * 
     * @param object $userModel
     * 
     * @return bool success status
     */
    public function login($userModel) {
        // gets user input from the html form
        extract($_POST);

        // sanitizes the input
        $this->email = htmlspecialchars($email);
        $this->password = htmlspecialchars($password);
    }

    /**
     * validates the email
     * 
     * @return bool true on error, false otherwise
     */
    private function validateEmail() {
        if (empty($this->email)) {
            $this->loginError = "email-cant-be-empty";
            return true;
        }

        return false;
    }

    /**
     * validates the password
     * 
     * @return bool true on error, false otherwise
     */
    private function validatePassword() {
        if (empty($this->password)) {
            $this->loginError = "password-cant-be-empty";
            return true;
        }

        return false;
    }

    /**
     * checks if the email and the password belong to an account
     * 
     * @param object $userModel
     * 
     * @return bool success status
     */
    private function areCredentialsCorrect($userModel) {
        if (password_verify($this->password, $userModel->getUserPassword($this->email))) {
            return true;
        }
        
        return false;
    }
}