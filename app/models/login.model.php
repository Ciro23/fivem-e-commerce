<?php

class LoginModel extends Mvc\Model {

    /**
     * @var string|bool $loginError
     */
    public $loginError = false;

    /**
     * performs the login action
     * 
     * @return bool success status
     */
    public function login() {
        // gets user input from the html form
        extract($_POST);

        // sanitizes the input
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
    }

    /**
     * validates the email
     * 
     * @param string $email
     * 
     * @return bool true on error, false otherwise
     */
    private function validateEmail($email) {
        if (empty($email)) {
            $this->loginError = "email-cant-be-empty";
            return true;
        }

        return false;
    }

    /**
     * validates the password
     * 
     * @param string $password
     * 
     * @return bool true on error, false otherwise
     */
    private function validatePassword($password) {
        if (empty($password)) {
            $this->loginError = "password-cant-be-empty";
            return true;
        }

        return false;
    }
}