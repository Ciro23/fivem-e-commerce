<?php

class LoginModel extends Mvc\Model {

    /**
     * @var string $error
     */
    private $error = "";

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
    public function getError() {
        return $this->error;
    }

    /**
     * returns the email
     * 
     * @return string
     */
    public function getEmail() {
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
            $this->validateEmail()
            || $this->validatePassword()
        ) {
            return false;
        }

        // insert the data into the db and creates the session
        if ($this->areCredentialsCorrect($userModel)) {
            $_SESSION['uid'] = $userModel->getUserIdByEmail($this->data['email']);
            return true;
        }

        // in case of wrong credentials
        if ($userModel->PDOError) {
            $this->error = "something-went-wrong";
        } else {
            $this->error = "credentials-are-not-correct";
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
    private function validateEmail() {
        if (empty($this->data['email'])) {
            $this->error = "email-cant-be-empty";
            return true;
        }

        return false;
    }

    /**
     * checks if the password is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validatePassword() {
        if (empty($this->data['password'])) {
            $this->error = "password-cant-be-empty";
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
        $this->PDOError = true;
        return false;
    }
}
