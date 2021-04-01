<?php

class LoginModel extends Mvc\Model {

    /**
     * @var string|false $error
     */
    public $error = false;

    /**
     * @var string $email
     */
    public $email;

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

        // checks for errors
        if (
            $this->validateEmail()
            || $this->validatePassword()
        ) {
            return false;
        }

        // insert the data into the db and creates the session
        if ($this->areCredentialsCorrect($userModel)) {
            $_SESSION['uid'] = $userModel->getId($this->email);
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
     * validates the email
     * 
     * @return bool true on error, false otherwise
     */
    private function validateEmail() {
        if (empty($this->email)) {
            $this->error = "email-cant-be-empty";
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
        if (password_verify($this->password, $userModel->getPassword($this->email))) {
            return true;
        }
        $this->PDOError = true;
        return false;
    }
}
