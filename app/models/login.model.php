<?php

class LoginModel extends Mvc\Model {

    /**
     * @var string $loginError
     */
    private $loginError = "";

    /**
     * @var array $data contains all form data
     */
    private $data = [
        "email" => "",
        "password" => "",
    ];

    /**
     * returns the error
     * 
     * @return string
     */
    public function getLoginError() {
        return $this->loginError;
    }

    /**
     * returns the email
     * 
     * @return string
     */
    public function getUserEmail() {
        return $this->data['email'];
    }

    /**
     * performs the login action
     * 
     * @param array $inputData
     * @param object $userModel
     * 
     * @return bool success status
     */
    public function login($inputData, $userModel) {
        // gets form input
        $this->data = InputHelper::getFormInput($this->data, $inputData);

        // checks for errors
        if (
            $this->validateUserEmail()
            || $this->validateUserPassword()
        ) {
            return false;
        }

        // checks if the email and password are correct and creates the session
        if ($this->areCredentialsCorrect($userModel)) {
            $_SESSION['uid'] = $userModel->getUserIdByEmail($this->data['email']);
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

    /**
     * performs the logout action
     */
    public function logout() {
        session_destroy();
    }

    /**
     * checks if the email is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateUserEmail() {
        if (empty($this->data['email'])) {
            $this->loginError = "email-cant-be-empty";
            return true;
        }

        return false;
    }

    /**
     * checks if the password is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateUserPassword() {
        if (empty($this->data['password'])) {
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
        if (password_verify($this->data['password'], $userModel->getUserPasswordByEmail($this->data['email']))) {
            return true;
        }
        
        return false;
    }
}
