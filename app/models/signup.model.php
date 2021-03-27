<?php

class SignupModel extends Mvc\Model {

    /**
     * @var string error
     */
    public $error = false;

    public function signup() {
        // gets user input from the html form
        extract($_POST);

        // sanitizes the input
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        $rePassword = htmlspecialchars($rePassword);
    }

    /**
     * validate the username
     * 
     * @param string $username
     * 
     * @return bool true on error, false otherwise
     */
    private function validateUsername($username) {
        if (empty($username)) {
            $this->error = "username-cant-be-empty";
        } else if (strlen($username) < 4 || strlen($username) > 20) {
            $this->error = "username-length-must-be-between-4-and-20";
        }
        
        if ($this->error) {
            return true;
        }
        return false;
    }

    /**
     * validate the password
     * 
     * @param string $password
     * @param string $rePassword
     * 
     * @return bool true on error, false otherwise
     */
    private function validatePassword($password, $rePassword) {
        if (empty($password)) {
            $this->error = "password-cant-be-empty";
        } else if (strlen($password) < 6 || strlen($password) > 64) {
            $this->error = "password-length-must-be-between-6-and-64";
        } else if ($password != $rePassword) {
            $this->error = "passwords-do-not-match";
        }

        if ($this->error) {
            return true;
        }
        return false;
    }
}